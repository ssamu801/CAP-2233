<?php
require("connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['post_id']) && isset($_POST['comment_username']) && isset($_POST['comment_message'])) {
    $post_id = $_POST['post_id'];
    $comment_username = $_POST['comment_username'];
    $comment_message = $_POST['comment_message'];

    // Insert the comment into the comments table
    $commentQuery = "INSERT INTO comments (post_id, username, comment) VALUES (?, ?, ?)";
    $commentStmt = mysqli_prepare($conn, $commentQuery);
    mysqli_stmt_bind_param($commentStmt, "iss", $post_id, $comment_username, $comment_message);
    $commentResult = mysqli_stmt_execute($commentStmt);

    if (!$commentResult) {
        echo "Error inserting comment: " . mysqli_error($conn);
    }

    mysqli_stmt_close($commentStmt);
}
header("Location: index.php"); // Redirect back to the main page after comment submission
exit();
?>
