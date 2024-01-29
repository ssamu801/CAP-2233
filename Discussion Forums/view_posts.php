
<?php
require("connect.php");

$query = "SELECT * FROM posts ORDER BY created_at ASC";
$result = mysqli_query($conn, $query);

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $rawDateTime = $row['created_at'];
        $dateTimeObj = new DateTime($rawDateTime);
        $formattedDateTime = $dateTimeObj->format('Y/m/d h:i A');
        echo "<p><strong>{$row['username']}:</strong> ({$formattedDateTime})
              <br>{$row['message']}</p>";
    }
} else {
    echo "Error: " . mysqli_error($conn);
}

?>
