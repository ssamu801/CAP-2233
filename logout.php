<?php
    session_start();
    
    if(isset($_SESSION['userId'])) {
        session_unset();
        // Redirect to the login page or any other desired page after logout
        header('location: login.php');
        exit();
    } else {
        header('location: login.php');
        exit();
    }
?>

