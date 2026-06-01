<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

include "config.php";
$today = date("Y-m-d");

$result = $conn->query("
SELECT m.*, p.name, p.photo
FROM messages m
JOIN profiles p ON m.profile_id = p.id
WHERE '$today' BETWEEN m.start_date AND m.expire_date
ORDER BY m.id DESC
");

$data = [];

while($row = $result->fetch_assoc()){
    $data[] = $row;
}

echo json_encode($data);
?>