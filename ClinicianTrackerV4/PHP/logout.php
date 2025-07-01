<?php

session_start();
if(isset($_SESSION["clinician_id"]) && isset($_SESSION["clinician_first_name"]) && isset($_SESSION["clinician_last_name"])){

    session_unset();
    session_destroy();
    echo json_encode(["success" => true]);
    exit();
}