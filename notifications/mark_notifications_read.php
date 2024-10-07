<?php
session_start();
include 'db_connect.php';

$userId = $_SESSION['user_id'];

$query = "UPDATE notifications SET is_read = 1 WHERE posterID = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $userId);
$stmt->execute();
?>
