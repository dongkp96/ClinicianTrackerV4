<?php

session_start();
if(isset($_SESSION["clinician_id"]) && isset($_SESSION["patient_id"])){
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json");

        $data = json_decode(file_get_contents("php://input"), true);

        $visitNumber = $data["visitNumber"];
        $visitDate = $data["visitDate"];
        $painLevel = $data["painLevel"];
        $functionRating = $data["functionRating"];
        $goals = $data["goals"];
        $summary = $data["summary"];

        try{
            require_once "../db-connect.php";

            $query = "INSERT INTO visitnotes (pain_level, function_rating, goals_met, summary, visit_date, visit_number, patient_id) VALUES (:pain_level, :function_rating, :goals_met, :summary, :visit_date, :visit_number, :patient_id) ";

            $stmt = $pdo->prepare($query);

            $stmt->bindParam(":pain_level",$painLevel, PDO::PARAM_INT);
            $stmt->bindParam(":function_rating",$functionRating, PDO::PARAM_INT);
            $stmt->bindParam(":goals_met",$goals, PDO::PARAM_INT);
            $stmt->bindParam(":summary",$summary, PDO::PARAM_STR);
            $stmt->bindParam(":visit_date",$visitDate, PDO::PARAM_STR);
            $stmt->bindParam(":visit_number",$visitNumber,PDO::PARAM_INT);
            $stmt->bindParam(":patient_id",$_SESSION["patient_id"],PDO::PARAM_INT);

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