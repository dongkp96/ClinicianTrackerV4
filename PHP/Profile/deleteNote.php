<?php

session_start();


if(isset($_SESSION["clinician_id"]) && isset($_SESSION["patient_id"])){
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json");

        $data = json_decode(file_get_contents("php://input"), true);   
        $note_id = $data["note_id"];

        try{
            require_once "../db-connect.php";
            
            $query = "DELETE FROM visitnotes WHERE visit_id = :id";

            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":id", $note_id, PDO::PARAM_INT);
            $stmt->execute();
            echo json_encode(["success" => true]);
            exit();
        }catch(PDOException $e){
            http_response_code(500);
            echo json_encode(["error" => "database error", "details" => $e->getMessage()]);
                
        }
    }
}
