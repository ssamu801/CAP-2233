<?php
require("connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['comment_message'])) {
    $post_id = $_POST['post_id'];
    $comment_username = $_POST['comment_username'];
    $comment_message = $_POST['comment_message'];

    // TEMP VALUES
    $topic_id = 1;
    $user_id = 2;

    // Insert the comment into the comments table
    $commentQuery = "INSERT INTO comments (topic_id, user_id, comment) VALUES (?, ?, ?)";
    $commentStmt = mysqli_prepare($conn, $commentQuery);
    mysqli_stmt_bind_param($commentStmt, "iis", $topic_id, $user_id, $comment_message);
    $commentResult = mysqli_stmt_execute($commentStmt);

    if (!$commentResult) {
        echo "Error inserting comment: " . mysqli_error($conn);
    }

    mysqli_stmt_close($commentStmt);
}
header("Location: index.php"); 
exit();
?>
