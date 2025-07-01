<?php

session_start();
if(isset($_SESSION["clinician_id"]) && isset($_SESSION["clinician_first_name"]) && isset($_SESSION["clinician_last_name"])){
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        header("Access-Control-Allow-Origin: *");
        header('Content-Type: application/json');

        $data = json_decode(file_get_contents("php://input"), true);
        $patient_id = $data["id"];

        
        try{
            require_once "../db-connect.php";

            //query to select the following info from patients table where the ids match
            $query = "SELECT patient_id, first_name, last_name, diagnosis, age, dob, weight, height, gender FROM patients WHERE patient_id = :id";
            
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":id", $patient_id, PDO::PARAM_INT);
            $stmt->execute();

            $results = $stmt->fetch(PDO::FETCH_ASSOC);

            //conditional statement to see if there is a matching patient in the database
            if(!$results){
                echo json_encode(["success" =>false, "error" => "patient not found"]);
                exit();
            }

            //Sets session variables for patient information
            $_SESSION["patient_id"] =  $results["patient_id"];
            $_SESSION["patient_first_name"] = $results["first_name"];
            $_SESSION["patient_last_name"] = $results["last_name"];
            $_SESSION["patient_diagnosis"] = $results["diagnosis"];
            $_SESSION["patient_age"] = $results["age"];
            $_SESSION["patient_dob"] = $results["dob"];
            $_SESSION["patient_weight"] = $results["weight"];
            $_SESSION["patient_height"] = $results["height"];
            $_SESSION["patient_gender"] = $results["gender"];
            echo json_encode(["success" => true]);
            exit();
        }catch(PDOException $e){
            //error handling
            http_response_code(500);
            echo json_encode(["error" => "Database error", "details" => $e->getMessage()]);
            exit();
        }
    }else{
        header("Location: ../../index.php");
        exit();
    }
}