<?php
include "config.php";
if(!isset($_SESSION['login'])) exit;

$id = $_GET['id'];

$conn->query("DELETE FROM messages WHERE id=$id");

header("Location: add_message.php");
exit;
?>