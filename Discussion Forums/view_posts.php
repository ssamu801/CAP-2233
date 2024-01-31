<?php
require("connect.php");

// Handle comment submission

// Fetch and display posts
$queryPosts = "SELECT * FROM posts WHERE post_id = -1 ORDER BY created_at ASC";
$resultPosts = mysqli_query($conn, $queryPosts);

if ($resultPosts) {
    echo "<div style='margin: auto; width: 80%;'>";
    
    // Add a class to the table for styling
    echo "<table class='invisible-border' width='100%'>";

    while ($rowPost = mysqli_fetch_assoc($resultPosts)) {
        $rawDateTime = $rowPost['created_at'];
        $dateTimeObj = new DateTime($rawDateTime);
        $formattedDateTime = $dateTimeObj->format('Y-m-d h:i A');
        
        echo "<tr>";
        echo "<td><strong>{$rowPost['username']} </strong> {$formattedDateTime} <br>";
        echo "{$rowPost['message']}</td>";
        echo "</tr>";

        // Display comments for each post
        $postId = $rowPost['id'];
        $queryComments = "SELECT * FROM posts WHERE post_id != -1 AND post_id = $postId ORDER BY created_at ASC";
        $resultComments = mysqli_query($conn, $queryComments);

        // Comment submission form
        echo "<tr>";
        echo "<td style='padding-left: 20px;' colspan='3'>";
        echo "<form method='post' action='post_comment.php'>";
        echo "<input type='hidden' name='post_id' value='{$postId}'>";
        echo "<label for='comment_username'>username:</label>";
        echo "<input type='text' name='comment_username' required>";
        echo "<label for='comment_message'>Your Comment:</label>";
        echo "<textarea id='expandingTextarea' name='comment_message' rows='1' placeholder='Write a comment..' oninput='autoExpand(this)' required></textarea>";
        echo "<input type='submit' value='Submit Comment'>";
        echo "</form>";
        echo "</td>";
        echo "</tr>";

        if (mysqli_num_rows($resultComments) > 0) {

            echo "<tr>";
            echo "<td style='padding-left: 20px;'><strong>Comments</strong></td>";
            echo "</tr>";
            
            while ($rowComment = mysqli_fetch_assoc($resultComments)) {
                $rawCommentDateTime = $rowComment['created_at'];
                $commentDateTimeObj = new DateTime($rawCommentDateTime);
                $formattedCommentDateTime = $commentDateTimeObj->format('Y-m-d h:i A');

                echo "<tr>";
                echo "<td style='padding-left: 20px;'>";
                echo "<strong>{$rowComment['username']}</strong> {$formattedCommentDateTime} <br>";
                echo "{$rowComment['message']}</td>";
                echo "</tr>";
                // Add an empty row for spacing between comments
                echo "<tr><td>&nbsp;</td></tr>";
            }
        }
    }

    echo "</table>";
    echo "</div>"; 
} else {
    echo "Error fetching posts: " . mysqli_error($conn);
}
?>
