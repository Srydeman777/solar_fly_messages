<?php
include "config.php";
if(!isset($_SESSION['login'])) exit;

$id = $_GET['id'];

// optional: delete image file too
$res = $conn->query("SELECT photo FROM profiles WHERE id=$id");
$row = $res->fetch_assoc();

if($row){
    $file = "uploads/".$row['photo'];
    if(file_exists($file)){
        unlink($file);
    }
}

$conn->query("DELETE FROM profiles WHERE id=$id");

header("Location: add_profile.php");
exit;
?>