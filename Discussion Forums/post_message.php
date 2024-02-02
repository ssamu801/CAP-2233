<?php
require("connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $message = $_POST['message'];

    // TEMP VALUES
    $category_id = 1;
    $user_id = 2;
    $title = "TEMPORARY";

    $query = "INSERT INTO topics (category_ids, title, content, user_id) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);

    mysqli_stmt_bind_param($stmt, "issi", $category_id, $title, $message , $user_id);

    $result = mysqli_stmt_execute($stmt);

    if ($result) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
} else {
    header("Location: index.php");
    exit();
}

?>
