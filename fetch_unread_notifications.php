<?php
session_start();
include 'db_connect.php';

header('Content-Type: application/json');

// Assuming you have a session to track the logged-in user
$userID = $_SESSION['login_id'];

// Query to count unread notifications
$sql = "SELECT COUNT(*) as unread_count FROM notifications WHERE posterID=? AND is_read=0";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userID);
$stmt->execute();
$result = $stmt->get_result();
$unreadCount = 0;

if ($result && $row = $result->fetch_assoc()) {
    $unreadCount = $row['unread_count'];
}

echo json_encode(['unread_count' => $unreadCount]);
?>
