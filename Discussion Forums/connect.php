<?php
    $conn = mysqli_connect("localhost", "root", "p@ssword") or die ("Unable to connect!". mysqli_error($conn));
    mysqli_select_db($conn, "discussion_forum");
?>