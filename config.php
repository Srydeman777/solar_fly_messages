<?php
session_start();

$admin_password = "Earth123@@";

// Aiven MySQL credentials
$db_host = "mysql-1a5b9f96-rihankhanpro717-5f17.l.aivencloud.com";
$db_user = "avnadmin";
$db_pass = "AVNS_Yt1W_jgHMN1LD4dMOQG";
$db_name = "defaultdb";
$db_port = 20501;

// Create connection
$conn = new mysqli(
    $db_host,
    $db_user,
    $db_pass,
    $db_name,
    $db_port
);

// Check connection
if($conn->connect_error){
    http_response_code(500);
    exit(json_encode([
        "error" => "Database connection failed",
        "details" => $conn->connect_error
    ]));
}

// Set charset for emojis + multilingual support
$conn->set_charset("utf8mb4");
?>