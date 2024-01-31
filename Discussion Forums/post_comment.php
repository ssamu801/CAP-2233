<?php
require("connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['post_id']) && isset($_POST['comment_username']) && isset($_POST['comment_message'])) {
    $post_id = $_POST['post_id'];
    $comment_username = $_POST['comment_username'];
    $comment_message = $_POST['comment_message'];

    // Insert the comment into the comments table
    $commentQuery = "INSERT INTO posts (username, message, post_id) VALUES (?, ?, ?)";
    $commentStmt = mysqli_prepare($conn, $commentQuery);
    mysqli_stmt_bind_param($commentStmt, "ssi", $comment_username, $comment_message, $post_id);
    $commentResult = mysqli_stmt_execute($commentStmt);

    if (!$commentResult) {
        echo "Error inserting comment: " . mysqli_error($conn);
    }

    mysqli_stmt_close($commentStmt);
}
header("Location: index.php"); 
exit();
?>
