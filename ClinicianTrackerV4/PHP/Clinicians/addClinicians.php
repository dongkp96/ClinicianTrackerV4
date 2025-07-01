<?php

if($_SERVER["REQUEST_METHOD"] == "POST"){
    header("Access-Control-Allow-Origin: *");
    header('Content-Type: application/json');
    /*
    This is needed to be done with json_decode because when you used the POST method 
    you sent the data as a json string
    */
    $data = json_decode(file_get_contents("php://input"), true); 
    $firstName = $data["first_name"];
    $lastName = $data["last_name"];
    $userName = $data["username"];
    $passkey = $data["passkey"];


    try{
        require_once "../db-connect.php";

        $query = "SELECT username FROM clinicians where username = :username";

        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":username", $username);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if($user){
            echo json_encode(["success" => false, "error" => "username taken"]);
            exit();
        }

        $query = "INSERT INTO clinicians (username, passkey, first_name, last_name) VALUES (:username, :passkey, :first_name, :last_name)";

        $stmt = $pdo->prepare($query);

        $options = [
            'cost' => 12
        ];
        
        $hashedPWD = password_hash($passkey, PASSWORD_BCRYPT, $options);

        $stmt->bindParam(":username", $userName);
        $stmt->bindParam(":passkey", $hashedPWD);
        $stmt->bindParam(":first_name", $firstName);
        $stmt->bindParam(":last_name", $lastName);

        $stmt->execute();
        echo json_encode(["success"=> true]);
        exit();

    }catch(PDOException $e){
        http_response_code(500);
        echo json_encode(["success" => false, "error" => $e->getMessage()]);
    }


}else{
    header("Location: ../../index.php");
    exit();
}