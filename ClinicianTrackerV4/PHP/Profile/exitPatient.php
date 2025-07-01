<?php

session_start();
if(isset($_SESSION["patient_id"])){
    unset($_SESSION["patient_id"]);
    unset($_SESSION["patient_first_name"]);
    unset($_SESSION["patient_last_name"]);
    unset($_SESSION["patient_diagnosis"]);
    unset($_SESSION["patient_age"]);
    unset($_SESSION["patient_dob"]);
    unset($_SESSION["patient_weight"]);
    unset($_SESSION["patient_height"]);
    unset($_SESSION["patient_gender"]);

    echo json_encode(["success" => true]);
    exit();
}