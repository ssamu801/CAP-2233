<?php
// Include your database connection file
include '../db_connect.php';

// Get selected date, month, and year from the AJAX request
$selectedDate = $_POST['selectedDate'];
$selectedMonth = $_POST['selectedMonth'];
$selectedYear = $_POST['selectedYear'];
$mode = $_SESSION['session_mode'];

if(isset($_SESSION['counselorID'])){
    $counselorID = $_SESSION['counselorID'];
    // Example query to retrieve time slots from the database
    $query = "SELECT date, time_from, time_to, COUNT(*) AS count_occurrences
            FROM availability
            WHERE status = 'Available'
            AND date = '$selectedYear-$selectedMonth-$selectedDate'
            AND counselorID = '$counselorID'
            AND mode = '$mode'
            GROUP BY date, time_from, time_to
            ORDER BY time_to;";
    // Execute the query and fetch the results
    // You would need to replace this with your actual database query
    $result = mysqli_query($conn, $query);

    // Initialize the response variable
    $response = '';

    // Check if there are any time slots retrieved from the database
    if (mysqli_num_rows($result) > 0) {
    // Loop through each time slot and add input fields for time_from and time_to
        while ($row = mysqli_fetch_assoc($result)) {
            $response .= '<div class="ml-4 mr-4 d-flex justify-content-center items-center mb-2">';
            $response .= '<input type="radio" name="selectedTimeSlot" value="' . $row['time_from'] . ' - ' . $row['time_to'] . '">';
            $response .= '<input type="time" name="time_from" class="form-control input-field ml-2" value="' . $row['time_from'] . '" readonly>';
            $response .= '<h3 class="mx-3"> - </h3>';
            $response .= '<input type="time" name="time_to" class="form-control input-field" value="' . $row['time_to'] . '" readonly>';
            $response .= '</div>';
        
        }
    } else {
        // If no time slots are available, display a message or handle accordingly
        $response = '<div>No time slots available for this date.</div>';
    }

    echo $response; // Send the response back to the JavaScript code
}
else{
    // Example query to retrieve time slots from the database
    $query = "SELECT date, time_from, time_to, COUNT(*) AS count_occurrences
            FROM availability
            WHERE status = 'Available'
            AND date = '$selectedYear-$selectedMonth-$selectedDate'
            AND mode = '$mode'
            GROUP BY date, time_from, time_to
            ORDER BY time_to;";
    // Execute the query and fetch the results
    // You would need to replace this with your actual database query
    $result = mysqli_query($conn, $query);

    // Initialize the response variable
    $response = '';

    // Check if there are any time slots retrieved from the database
    if (mysqli_num_rows($result) > 0) {
    // Loop through each time slot and add input fields for time_from and time_to
    while ($row = mysqli_fetch_assoc($result)) {
        $response .= '<div class="ml-4 mr-4 d-flex justify-content-center items-center mb-2">';
        $response .= '<input type="radio" name="selectedTimeSlot" value="' . $row['time_from'] . ' - ' . $row['time_to'] . '">';
        $response .= '<input type="time" name="time_from" class="form-control input-field ml-2" value="' . $row['time_from'] . '" readonly>';
        $response .= '<h3 class="mx-3"> - </h3>';
        $response .= '<input type="time" name="time_to" class="form-control input-field" value="' . $row['time_to'] . '" readonly>';
        $response .= '</div>';
        
    }
} else {
    // If no time slots are available, display a message or handle accordingly
    $response = '<div>No time slots available for this date.</div>';
}

echo $response; // Send the response back to the JavaScript code
}

?>

<?php 
    /* 
        9-48
        54
    */
?>