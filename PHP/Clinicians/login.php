<?php
session_start();
if($_SERVER["REQUEST_METHOD"] == "POST"){
    header("Access-Control-Allow-Origin: *");
    header('Content-Type: application/json');

    $data = json_decode(file_get_contents("php://input"), true); 
    $username = $data["username"];
    $password = $data["password"];

    try{
        require_once '../db-connect.php';

        $query = "SELECT * FROM clinicians WHERE username= :username";
        $stmt = $pdo->prepare($query);

        $stmt->bindParam(":username" , $username);
        $stmt->execute();

        $results = $stmt->fetch(PDO::FETCH_ASSOC);

        if(!$results){
            echo json_encode(["success" => false, "error" => "username not found"]);
            exit;
        }

        $storedPWD = $results["passkey"];

        if(password_verify($password, $storedPWD)){
            $_SESSION["clinician_id"] = $results["clinician_id"];
            $_SESSION["clinician_first_name"] = $results["first_name"];
            $_SESSION["clinician_last_name"] = $results["last_name"];
            echo json_encode(["success" => true,"clinician_id" => $results["clinician_id"]
            , "first_name" => $results["first_name"], "last_name" => $results["last_name"] ]);
            exit();
        }else{
            echo json_encode(["success" => false, "error" => "Invalid password."]);
            exit();
        }

        

    }catch(PDOException $e){
        http_response_code(500);
        echo json_encode(['error' => 'Database error', 'details' => $e->getMessage()]);        
    }
}else{
    header("Location: ../../index.php");
    exit();
}