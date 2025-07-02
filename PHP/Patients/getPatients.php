<?php
session_start();
if(isset($_SESSION["clinician_id"]) && isset($_SESSION["clinician_first_name"]) && isset($_SESSION["clinician_last_name"])){
    $clinician_id = $_SESSION["clinician_id"];
    if($_SERVER["REQUEST_METHOD"] == "GET"){
        header("Access-Control-Allow-Origin: *");
        header('Content-Type: application/json');

        try{
            require_once '../db-connect.php';
            $query = "SELECT patient_id, first_name, last_name FROM patients WHERE clinician_id = :clinician_id";

            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":clinician_id", $clinician_id, PDO::PARAM_INT);
            $stmt->execute();
            $patients = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($patients);
            exit();

        }catch(PDOException $e){
            http_response_code(500);
            echo json_encode(["error" => "Database error", "details" => $e->getMessage()]);
            exit();
        }

    }else{
        header("Location: ../../index.php");
        exit();
    }    
}else{
    session_destroy();
    header("Location:../../index.php");
    exit();
}


