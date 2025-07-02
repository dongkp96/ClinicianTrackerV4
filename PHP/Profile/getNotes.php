<?php

session_start();
if(isset($_SESSION["clinician_id"]) && isset($_SESSION["patient_id"])){
    if($_SERVER["REQUEST_METHOD"] == "GET"){
        header("Access-Control-Allow-Origin: *");
        header('Content-Type: application/json');
        
        try{
            require_once "../db-connect.php";
            //Query to select the following info associated with the ID in ascending order via visit numbers
            $query = "SELECT visit_id, pain_level, function_rating, goals_met, summary, visit_date, visit_number FROM visitnotes WHERE patient_id = :id ORDER BY visit_number ASC";

            $stmt = $pdo->prepare($query);
            $stmt -> bindParam(":id", $_SESSION["patient_id"], PDO::PARAM_INT);
            $stmt->execute();
            $notes = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($notes);

            exit();
        }catch(PDOException $e){
            http_response_code(500);
            echo json_encode(["error" => "Database error", "details" => $e->getMessage()]);
            exit();            
        }
    }
}