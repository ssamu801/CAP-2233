<?php     
// Include database configuration file 
require_once './db_connect.php'; 
 
$postData = $statusMsg = $valErr = ''; 
$status = 'danger'; 

// If the form is submitted 
if(isset($_POST['submit'])){ 
     
    // Get event info 
    $_SESSION['postData'] = $_POST; 
    $title = !empty($_POST['title'])?trim($_POST['title']):''; 
    $description = !empty($_POST['description'])?trim($_POST['description']):''; 
    $location = !empty($_POST['location'])?trim($_POST['location']):''; 
   // $date = !empty($_POST['date'])?trim($_POST['date']):''; -- UPDATEDDDDDDDDDDDDDDDDDDDDD
    $selectedSched = !empty($_POST['selectedDate'])?trim($_POST['selectedDate']):''; 

    $schedParts = explode(', ', $selectedSched);

    // Extract the date part and convert it to the desired format (YYYY-MM-DD)
    $datePart = date('Y-m-d', strtotime($schedParts[0]));

// Extract the time range part and split it into start and end times
    $timeRange = explode(' - ', $schedParts[2]);
    $startTime = date('H:i:s', strtotime($timeRange[0]));
    $endTime = date('H:i:s', strtotime($timeRange[1]));

    $time_from = $startTime; 
    $time_to = $endTime; 
    $user_name = !empty($_POST['client_name'])?trim($_POST['client_name']):''; 
    $user_email = !empty($_POST['attendees'])?trim($_POST['attendees']):''; 
    $student_id = !empty($_POST['student_id'])?trim($_POST['student_id']):''; 
    $counselor_name = !empty($_POST['counselor_name'])?trim($_POST['counselor_name']):''; 
    $counselor_email = !empty($_POST['attendees2'])?trim($_POST['attendees2']):''; 
    $notes = !empty($_POST['notes'])?trim($_POST['notes']):''; 
    $urgency = !empty($_POST['urgency'])?trim($_POST['urgency']):''; 
    
     
    // Validate form input fields 
    if(empty($title)){ 
        $valErr .= 'Please enter event title.<br/>'; 
    } 
    if(empty($urgency)){ 
        $urgency = 'Not Urgent';
    } 
    if(empty($notes)){
        $notes = 'No notes indicated.';
    }

     
    // Check whether user inputs are empty 
    if(empty($valErr)){ 
        // Insert data into the database 
        $sqlQ = "INSERT INTO events (title, description, location, date, time_from, time_to, created, user_name, user_email, counselor_email, status, student_id, notes, urgency) VALUES (?, ?, ?, ?, ?, ?, NOW(), ?, ?, ?, ?, ?, ?, ?)"; 
        $stmt = $conn->prepare($sqlQ); 
        $stmt->bind_param("sssssssssssss", $db_title, $db_description, $db_location, $db_date, $db_time_from, $db_time_to, $db_user_name, $db_email1, $db_email2, $db_status, $db_student_id,  $db_notes,  $db_urgency); 
        $db_title = $title; 
        $db_description = $description; 
        $db_location = $location; 
        $db_notes = $notes;
        $db_urgency = $urgency;

        $db_time_from = $time_from; 
        $db_time_to = $time_to; 
        $db_date = $datePart; 
        $db_user_name = $user_name; 
        $db_email1 = $user_email; 
        $db_email2 = $counselor_email; 
        $db_status = "Pending";
        $db_student_id = $student_id; 
        $insert = $stmt->execute(); 
         
        // Check if the insert was successful before redirecting
        if($insert){ 
            $_SESSION['success_message'] = "Your request has been submitted successfully!";
            // Redirect to another page
            // JavaScript for automatic redirect 
            echo '<script>
            
                function submitFormAndToast() {
                    alert_toast("Data successfully saved.", "success");
                    setTimeout(function() {
                        window.location.href = "redirect_page.php"; // Replace with the actual URL
                    }, 2000); // 2000 milliseconds = 2 seconds delay
                }

    submitFormAndToast();
</script>';
        } else { 
            $statusMsg = 'Something went wrong, please try again after some time.'; 
        } 
    } else { 
        $statusMsg = '<p>Please fill all the mandatory fields:</p>'.trim($valErr, '<br/>'); 
    }
    
    $_SESSION['status_response'] = array('status' => $status, 'status_msg' => $statusMsg); 
    exit(); 
}
?>

<!-- Your HTML or PHP content here -->

<script type="text/javascript">
    function redirectAfterDelay(url, delay) {
        setTimeout(function() {
            window.location.href = url;
        }, delay);
    }

    function submitFormAndToast() {
    // Here, submit the form using AJAX or any other method
    // After successful submission, display the toast message
    alert_toast("Data successfully saved.", 'success');

    // Redirect the user after a delay of 2 seconds (adjust the delay as needed)
    setTimeout(function () {
        window.location.href = "index.php?page=appointments/success_page"; // Replace 'redirect_page.php' with the actual URL
    }, 2000); // 2000 milliseconds = 2 seconds
    
    }
</script>

<?php
/* Changes as of 11:00PM - May 6, 2024
    Main changes: Added counselor notes and urgency

    - Changed line 16
    - Added line 21
    - Added line 24 - 26
    - Changed line 32 - 33
    - Changed line 40
    - Added line 46 - 51
    - Added line 54
    - Added line 59
	

   End of Changes*/
?>