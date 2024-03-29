<?php
include 'db_connect.php'; // Include the database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // If the register button is clicked
    if (isset($_POST['registerbtn'])) {
        // Get user input from the registration form
        $idNum = mysqli_real_escape_string($conn, $_POST['idNum']);
        $username = mysqli_real_escape_string($conn, $_POST['name']);
        $fullname = mysqli_real_escape_string($conn, $_POST['fullName']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $firstPassword = mysqli_real_escape_string($conn, $_POST['firstPassword']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);

        // Check if userID (idNum) is already taken
        $checkQuery = "SELECT * FROM users WHERE id = '$idNum'";
        $result = mysqli_query($conn, $checkQuery);

        // Check for query execution errors
        if (!$result) {
            die("Error in query: " . mysqli_error($conn));
        }

        if (mysqli_num_rows($result) > 0) {
            $error_message = "UserID is already taken.";
            echo "<script>alert('$error_message'); window.location.href='login.php';</script>";        
        } else {
            // Check if passwords match
            if ($firstPassword !== $password) {
                $error_message = "Passwords do not match";
                echo "<script>alert('$error_message'); window.location.href='login.php';</script>";
            } else {
                // Hash the password before saving it to the database
                $hashed_password = md5($password);

                // SQL query to insert user data into the database
                $query = "INSERT INTO users (id, name, username, email, password, type) 
                        VALUES($idNum, '$fullname', '$username', '$email', '$hashed_password', 1)";

                // Check for query execution errors
                if (mysqli_query($conn, $query)) {
                    $error_message = "Registration completed.";
                    echo "<script>alert('$error_message'); window.location.href='login.php';</script>";
                } else {
                    $error_message = "Registration failed! Please try again.";
                    echo "<script>alert('$error_message'); window.location.href='login.php';</script>";
                }
            }
        }
    }
}
?>
