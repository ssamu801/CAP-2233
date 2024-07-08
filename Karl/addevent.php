<?php     

// Include database configuration file 
require_once './db_connect.php'; 
 
$postData = $statusMsg = $valErr = ''; 
$status = 'danger'; 
 
// If the form is submitted 
if(isset($_POST['Accept'])){ 
     
    // Get event info 
    $_SESSION['postData'] = $_POST; 
    $userID = !empty($_POST['userID'])?trim($_POST['userID']):''; 
    $student_id = !empty($_POST['student_id'])?trim($_POST['student_id']):''; 
    $counselor_email = !empty($_POST['counselor_email'])?trim($_POST['counselor_email']):''; 
    $counselor_name = !empty($_POST['counselor_name'])?trim($_POST['counselor_name']):''; 
    $user_email = !empty($_POST['user_email'])?trim($_POST['user_email']):''; 
    $user_name = !empty($_POST['user_name'])?trim($_POST['user_name']):''; 
    $location = !empty($_POST['location'])?trim($_POST['location']):''; 
    $time_from = !empty($_POST['time_from'])?trim($_POST['time_from']):''; 
    $time_to = !empty($_POST['time_to'])?trim($_POST['time_to']):''; 
    $date = !empty($_POST['date'])?trim($_POST['date']):''; 
     
    // Check whether user inputs are empty 
    if(empty($valErr)){ 
        
        $sqlQ = "INSERT INTO event_notifications (id, description, user_email, counselor_name, time, event_start, location, event_end, event_date, event_status, user_name) VALUES (?, ?, ?, ?, NOW(), ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sqlQ);
        $stmt->bind_param("isssssssss", $student_id, $notif_desc, $user_email, $counselor_name, $time_from, $location, $time_to, $date, $event_status, $user_name);
        $notif_desc = "Your appointment has been confirmed";
        $event_status = "Pending";
        $insert = $stmt->execute();

        // Insert data into the database 
        $sqlQ = "UPDATE events SET location=?, counselor_name=?, counselor_email=?, status=? WHERE id=?";
        $stmt = $conn->prepare($sqlQ);
        $stmt->bind_param("ssssi", $location, $counselor_name, $counselor_email, $db_status, $db_userID);
        $db_status = "Accepted";
        $db_userID = $userID;
        $insert = $stmt->execute();
        if($insert){ 
            $event_id = $db_userID; 
             
            unset($_SESSION['postData']); 
             
            // Store event ID in session 
             $_SESSION['last_event_id'] = $event_id; 
             
             echo '<script type="text/javascript">
             setTimeout(function() {
                 window.location.href = "' . $googleOauthURL . '";
             }, 0000); 
         </script>';
            exit(); 
        }else{ 
            $statusMsg = 'Something went wrong, please try again after some time.'; 
        } 
    }else{ 
        $statusMsg = '<p>Please fill all the mandatory fields:</p>'.trim($valErr, '<br/>'); 
    } 
}else if(isset($_POST['Reject'])){ 
    $_SESSION['postData'] = $_POST; 
    $userID = !empty($_POST['userID'])?trim($_POST['userID']):''; 

    $sqlQ = "UPDATE events SET status=? WHERE id =?;"; 
    $stmt = $conn->prepare($sqlQ); 
    $stmt->bind_param("si", $db_status, $db_userID); 
    $db_status = "Rejected";
    $db_userID = $userID; 
    $insert = $stmt->execute();

    if($insert){
        echo '<script type="text/javascript">
                        setTimeout(function() {
                            window.location.href = "$googleOauthURL";
                        }, 0000); 
                </script>';
    }
} 
 
$_SESSION['status_response'] = array('status' => $status, 'status_msg' => $statusMsg); 
 
exit(); 
?>
<script type="text/javascript">
    function redirectAfterDelay(url, delay) {
        setTimeout(function() {
            window.location.href = url;
        }, delay);
    }
</script>

<?php
/* Changes as of 7/8/2024
    Main changes: Added user email and username. Updated queries

   Lines added: 
	18-19
	28
	30
	32

   End of Changes*/
?>