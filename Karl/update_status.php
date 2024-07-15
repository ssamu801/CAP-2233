<?php
include './db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $appointment_id = $_POST['id'];
    $new_status = $_POST['status'];

    // Update the status in the database
    $query = "UPDATE events SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $new_status, $appointment_id);

    if ($stmt->execute()) {
        echo "Status successfully updated to ". $new_status .".";
    } else {
        echo "Error updating status.";
    }

    $stmt->close();
    $conn->close();
}
?>
