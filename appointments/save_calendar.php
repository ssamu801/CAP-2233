<?php
session_start();
include_once 'config.php'; 
include './db_connect.php'; // Include your database connection file

if (!isset($_SESSION['login_id'])) {
    die('User not logged in');
}

$counselorID = $_SESSION['login_id'];
$data = json_decode($_POST['calendar'], true);

if ($data) {
    $stmt = $conn->prepare("INSERT INTO availability (counselorID, date, time_from, time_to, status, mode) VALUES (?, ?, ?, ?, ?, ?)");

    foreach ($data as $entry) {
        if ($entry['status'] === 'Leave') {
            $stmt->bind_param('isssss', $counselorID, $entry['date'], $entry['time_from'], $entry['time_to'], $entry['status'], $entry['mode']);
        } else {
            $stmt->bind_param('isssss', $counselorID, $entry['date'], $entry['time_from'], $entry['time_to'], $entry['status'], $entry['mode']);
        }
        $stmt->execute();
    }

    $stmt->close();
    $conn->close();
    echo 'Calendar saved successfully';
} else {
    echo 'No data received';
}
?>
