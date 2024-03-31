<?php
include './db_connect.php'; // Include the database connection file

// Get POST data and sanitize inputs
$article_id = $_POST['article_id'];
$title = $_POST['title'];
$login_id = $_POST['login_id'];
$user_rating = $_POST['user_rating'];
$type = $_POST['type'];


$conn->query("INSERT INTO `resources_ratings` (`article_id`, `title`, `user_rating`, `voter_id` , `type`) VALUES ('$article_id', '$title', $user_rating, $login_id, '$type')");

?>
