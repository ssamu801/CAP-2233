<?php
session_start(); // Start session

// Check if the action is to unset counselorID session variable
if (isset($_POST['action']) && $_POST['action'] === 'unsetCounselorID') {
    unset($_SESSION['counselorID']); // Unset counselorID session variable
    echo 'Counselor ID session variable unset successfully.';
    exit; // Exit to prevent further execution
}

// Check if counselorID is posted and update session variable
if (isset($_POST['counselorID'])) {
    $_SESSION['counselorID'] = $_POST['counselorID']; // Update session variable with counselor ID

    // Fetch counselor details from database (optional)
    include '../db_connect.php'; // Include database connection
    $id = $_SESSION['counselorID'];
    $result = $conn->query("SELECT name, email FROM users WHERE id = $id");

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['counselorName'] = $row['name']; // Store counselor name in session
        $_SESSION['counselorEmail'] = $row['email']; // Store counselor email in session
        echo 'Counselor ID session variable updated successfully.';
    } else {
        echo 'Error: Unable to fetch counselor details.';
    }
} else {
    echo 'Error: No valid data received.';
}
?>

