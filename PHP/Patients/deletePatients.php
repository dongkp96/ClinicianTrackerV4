<?php

session_start();
if(isset($_SESSION["clinician_id"]) && isset($_SESSION["clinician_first_name"]) && isset($_SESSION["clinician_last_name"])){
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json");

        $data = json_decode(file_get_contents("php://input"), true);
        $id = $data["id"];

        try{
            require_once "../db-connect.php";

            $query = "DELETE FROM patients WHERE patient_id = :id";

            $stmt = $pdo->prepare($query);
            $stmt ->bindparam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();

            echo json_encode(["success" => true]);
            exit();
        }catch(PDOException $e){
            http_response_code(500);
            echo json_encode(["error" => "database error", "details" => $e->getMessage()]);
            exit();
                
        }
    }
}else{
    header("Location: ../../index.php");
    exit();
}