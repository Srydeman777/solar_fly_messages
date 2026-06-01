<?php
session_start();

$admin_password = "Earth123@@";

// Aiven MySQL credentials
$db_host = "mysql-1a5b9f96-rihankhanpro717-5f17.l.aivencloud.com";
$db_user = "avnadmin";
$db_pass = "AVNS_Yt1W_jgHMN1LD4dMOQG";
$db_name = "solar_data";
$db_port = 20501;

// Create connection
$conn = new mysqli(
    $db_host,
    $db_user,
    $db_pass,
    $db_name,
    $db_port
);

// Connection check
if ($conn->connect_error) {
    http_response_code(500);
    die("Database connection failed: " . $conn->connect_error);
}

// UTF-8 support
$conn->set_charset("utf8mb4");
?>
