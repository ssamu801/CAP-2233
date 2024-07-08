<?php
session_start(); // Start session
include '../db_connect.php';
if(isset($_POST['counselorID'])) {
    $_SESSION['counselorID'] = $_POST['counselorID']; // Update session variable with counselor ID

    $id =  $_SESSION['counselorID'];

    $result = $conn->query("SELECT name, email FROM users WHERE id = $id");

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $counselorName = $row['name'];
        $counselorEmail = $row['email'];
    
        // Assign values to session variables
        $_SESSION['counselorName'] = $counselorName;
        $_SESSION['counselorEmail'] = $counselorEmail;
    }
}
?>
