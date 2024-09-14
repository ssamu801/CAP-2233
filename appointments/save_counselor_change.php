<?php
session_start();
if ($_SESSION['login_type'] != 3) {
    header("Location: index.php?page=home");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include '../db_connect.php';

    $new_counselor = $_POST['new_counselor'];
    $reason = $_POST['reason'];
    $goal = $_POST['goal'];
    $intervention = $_POST['intervention'];
    $user_id = $_POST['user_id'];

    $stmt = $conn->prepare("UPDATE users SET counselor_id = ? WHERE id = ?");
    $stmt->bind_param("ii", $new_counselor, $user_id);
    $stmt->execute();

    $stmt = $conn->prepare("INSERT INTO counselor_changes (user_id, old_counselor_id, new_counselor_id, reason, goal, intervention) 
                            VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iiisss", $user_id, $_SESSION['login_id'], $new_counselor, $reason, $goal, $intervention);
    $stmt->execute();

    header("Location: index.php?page=session_records&id=".$user_id);
    exit;
}
