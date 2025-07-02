<?php

session_start();
if(isset($_SESSION["clinician_id"]) && isset($_SESSION["clinician_first_name"]) && isset($_SESSION["clinician_last_name"])){

    $clinician_id = $_SESSION["clinician_id"];
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json");
        
        $data = json_decode(file_get_contents("php://input"), true);
        $first_name = $data["firstName"];
        $last_name = $data["lastName"];
        $diagnosis = $data["diagnosis"];
        $weight = (int)$data["weight"];
        $height = (int)$data["height"];
        $age = (int)$data["age"];
        $dob = $data["dob"];
        $gender = $data["gender"];



        try{
            require_once "../db-connect.php";
            $query = 'INSERT INTO patients (first_name, last_name, diagnosis, age, dob, weight, height, gender,clinician_id) VALUES (:first_name, :last_name, :diagnosis, :age, :dob, :weight, :height, :gender ,:clinician_id )';

            $stmt = $pdo->prepare($query);

            $stmt->bindParam(":first_name", $first_name);
            $stmt->bindParam(":last_name", $last_name);
            $stmt->bindParam(":diagnosis", $diagnosis);
            $stmt->bindParam(":age", $age);
            $stmt->bindParam(":dob", $dob);
            $stmt->bindParam(":weight", $weight);
            $stmt->bindParam(":height", $height);
            $stmt->bindParam(":gender", $gender);
            $stmt->bindParam(":clinician_id", $clinician_id);

            $stmt->execute();
            echo json_encode(["success" => true]);
            exit();

        }catch(PDOException $e){
            http_response_code(500);
            echo json_encode(["success" => false, "error" => $e->getMessage()]);
            exit();
        }
    }else{
        header("Location: ../../index.php");
        exit();        
    }


}else{
    header("Location: ../../index.php");
    exit();
}