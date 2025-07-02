<?php

session_start();

if(isset($_SESSION["clinician_id"]) && isset($_SESSION["patient_id"])){
    if($_SERVER["REQUEST_METHOD"] == "GET"){
        header("Access-Control-Allow-Origin: *");
        header('Content-Type: application/json');
        $id = $_SESSION["patient_id"];
        
        try{
            require_once "../db-connect.php";

            $query = "SELECT pain_level, function_rating, visit_number FROM visitnotes WHERE patient_id = :id ORDER BY visit_number";

            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();

            $visitInfo = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($visitInfo);
            exit();

        }catch(PDOException $e){
            http_response_code(500);
            echo json_encode(["error" => "Database error", "details" => $e->getMessage()]);
            exit();
        }
    }
}