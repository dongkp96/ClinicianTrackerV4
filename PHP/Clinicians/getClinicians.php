<?php


if($_SERVER["REQUEST_METHOD"] == "GET"){
    header("Access-Control-Allow-Origin: *");
    header('Content-Type: application/json');
    try{
        require_once "../db-connect.php";

        $query = "SELECT clinician_id, first_name, last_name FROM clinicians";

        $stmt = $pdo->query($query);
        $clinicians = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($clinicians);
        exit();

    }catch(PDOException $e){
      http_response_code(500);
      echo json_encode(['error' => 'Database error', 'details' => $e->getMessage()]);
      exit();
    }
}else{
    header("Location: ../../index.php");
    exit();
}