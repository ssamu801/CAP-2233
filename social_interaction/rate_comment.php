<?php
session_start();
include '../db_connect.php';
$user_id = $_SESSION['login_id']; // Assuming user_id is stored in session

$action = $_POST['action'];
$comment_id = (int)$_POST['comment_id'];

$response = ['success' => false];

if ($action === 'helpful') {
    // Check if the user has already rated this comment
    $result = $conn->query("SELECT id, rating_type FROM comment_ratings WHERE user_id = $user_id AND comment_id = $comment_id");
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $rating_id = $row['id'];
        if ($row['rating_type'] === 'helpful') {
            // User is unpressing the helpful button
            $conn->query("DELETE FROM comment_ratings WHERE id = $rating_id");
            $conn->query("UPDATE comments SET helpful = helpful - 1 WHERE id = $comment_id");
        } else {
            // User is switching from unhelpful to helpful
            $conn->query("UPDATE comment_ratings SET rating_type = 'helpful' WHERE id = $rating_id");
            $conn->query("UPDATE comments SET helpful = helpful + 1, unhelpful = unhelpful - 1 WHERE id = $comment_id");
        }
    } else {
        // User is pressing the helpful button for the first time
        $conn->query("INSERT INTO comment_ratings (user_id, comment_id, rating_type) VALUES ($user_id, $comment_id, 'helpful')");
        $conn->query("UPDATE comments SET helpful = helpful + 1 WHERE id = $comment_id");
    }
} elseif ($action === 'unhelpful') {
    // Check if the user has already rated this comment
    $result = $conn->query("SELECT id, rating_type FROM comment_ratings WHERE user_id = $user_id AND comment_id = $comment_id");
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $rating_id = $row['id'];
        if ($row['rating_type'] === 'unhelpful') {
            // User is unpressing the unhelpful button
            $conn->query("DELETE FROM comment_ratings WHERE id = $rating_id");
            $conn->query("UPDATE comments SET unhelpful = unhelpful - 1 WHERE id = $comment_id");
        } else {
            // User is switching from helpful to unhelpful
            $conn->query("UPDATE comment_ratings SET rating_type = 'unhelpful' WHERE id = $rating_id");
            $conn->query("UPDATE comments SET helpful = helpful - 1, unhelpful = unhelpful + 1 WHERE id = $comment_id");
        }
    } else {
        // User is pressing the unhelpful button for the first time
        $conn->query("INSERT INTO comment_ratings (user_id, comment_id, rating_type) VALUES ($user_id, $comment_id, 'unhelpful')");
        $conn->query("UPDATE comments SET unhelpful = unhelpful + 1 WHERE id = $comment_id");
    }
}

// Retrieve updated counts
$result = $conn->query("SELECT helpful, unhelpful FROM comments WHERE id = $comment_id");
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $response['helpful_count'] = $row['helpful'];
    $response['unhelpful_count'] = $row['unhelpful'];
    $response['success'] = true;
}

echo json_encode($response);
?>
