<?php
    $conn = mysqli_connect("localhost", "root") or die ("Unable to connect!". mysqli_error($conn));
    mysqli_select_db($conn, "forum_db");
?>