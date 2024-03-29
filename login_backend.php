<?php
    include 'db_connect.php'; // Include the database connection file

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Check if the login form is submitted
        if (isset($_POST['loginbtn'])) {
            $idNum = $_POST['idNum'];
            $password = $_POST['password_login'];
            
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }

            // Prepare and execute a SQL query to authenticate the user
            $stmt = $conn->prepare("SELECT * FROM users WHERE id = ? LIMIT 1");
            $stmt->bind_param("s", $idNum);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();

            if ($user && isset($user['password'])) {
                $hashedPassword = $user['password'];

                if (md5($password) === $hashedPassword) {
                    // User authentication successful
                    session_start();
                    $_SESSION['id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    header("Location: index.php?page=home");
                    exit();
                }
            }
            // User authentication failed
            $error_message = "Invalid credentials";
            echo "<script>alert('$error_message'); window.location.href='login.php';</script>";
            // echo "<script>alert('$error_message');</script>";
            // header("Location: index.php?error=Invalid credentials"); // Redirect back to the login page with an error message
            exit();
        }
    }

    // Close the database connection
    $conn->close();
?>
