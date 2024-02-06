<?php
    $conn = mysqli_connect("cap-2233-cap2233.a.aivencloud.com:10292", "avnadmin", "AVNS_ZQTc4dKbpYkzHCia2nZ") or die ("Unable to connect!". mysqli_error($conn));
    mysqli_select_db($conn, "cap2233");
?>