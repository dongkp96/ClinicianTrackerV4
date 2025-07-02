<?php
session_start();
if(isset($_SESSION["clinician_id"]) && isset($_SESSION["patient_id"])){
    if($_SERVER["REQUEST_METHOD"]== "POST"){
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json");     
        
        $data = json_decode(file_get_contents("php://input"),true);
        $visitNumber = $data["visitNumber"];
        $visitDate = $data["visitDate"];
        $painLevel = $data["painLevel"];
        $function = $data["function"];
        $goals = $data["goals"];
        $summary = $data["summary"];
        $note_id = $data["note_id"];

        try{
            require_once "../db-connect.php";

            $query = "UPDATE visitnotes SET visit_number = :visitnumber, visit_date = :visitdate, pain_level = :painlevel, function_rating = :functionrating, goals_met = :goalsmet, summary = :summary WHERE visit_id = :id";

            $stmt = $pdo->prepare($query);

            $stmt->bindParam(":visitnumber", $visitNumber, PDO::PARAM_INT);
            $stmt->bindParam(":visitdate", $visitDate);
            $stmt->bindParam(":painlevel", $painLevel, PDO::PARAM_INT);
            $stmt->bindParam(":functionrating", $function, PDO::PARAM_INT);
            $stmt->bindParam(":goalsmet", $goals, PDO::PARAM_INT);
            $stmt->bindParam(":summary", $summary);
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