<?php
session_start();
include '../db_connect.php';

// Check if the request is a POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the timeSlotsData variable is set and not empty
    if (isset($_POST["timeSlotsData"]) && !empty($_POST["timeSlotsData"])) {
        // Decode the JSON data sent from the client
        $timeSlotsData = json_decode($_POST["timeSlotsData"], true);

        // Check if the selectedDate key exists in the decoded data
        if (isset($timeSlotsData["selectedDate"])) {
            // Get the selected date from the data
            $selectedDate = $timeSlotsData["selectedDate"];
            $selectedMonth = $timeSlotsData["selectedMonth"];
            $selectedYear = $timeSlotsData["selectedYear"];

            // Format the selected date into YYYY-MM-DD format
            $formattedDate = date("Y-m-d", strtotime("$selectedYear-$selectedMonth-$selectedDate"));

            // Insert the formatted date into the database
            $loginId = $_SESSION['login_id']; // Assuming you have a login ID stored in session

            // Check if time slots data exists
            if (isset($timeSlotsData["timeSlots"]) && !empty($timeSlotsData["timeSlots"])) {
                // Loop through the time slots data and insert into the database
                foreach ($timeSlotsData["timeSlots"] as $timeSlot) {
                    $timeFrom = $timeSlot["timeFrom"];
                    $timeTo = $timeSlot["timeTo"];

                    // Insert time slot data into the database
                    $sql = "INSERT INTO availability (counselorID, date, time_from, time_to) VALUES ('$loginId', '$formattedDate', '$timeFrom', '$timeTo')";
                    if (mysqli_query($conn, $sql)) {
                        echo "Schedule successfully saved.";
                    } else {
                        echo "Error: " . mysqli_error($conn);
                    }
                }
            } else {
                echo "Error: No time slots data received.";
            }
        } else {
            // Handle the case where selectedDate is not present in the data
            echo "Error: Selected date not found in data.";
        }
    } else {
        // Handle the case where timeSlotsData is not set or empty
        echo "Error: No data received.";
    }
} else {
    // Handle non-POST requests
    echo "Error: Invalid request method.";
}
?>
