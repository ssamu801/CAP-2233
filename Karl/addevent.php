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
    $location = !empty($_POST['location'])?trim($_POST['location']):''; 
    $time_from = !empty($_POST['time_from'])?trim($_POST['time_from']):''; 
    $time_to = !empty($_POST['time_to'])?trim($_POST['time_to']):''; 
    $date = !empty($_POST['date'])?trim($_POST['date']):''; 
     
    // Check whether user inputs are empty 
    if(empty($valErr)){ 
        
        $sqlQ = "INSERT INTO event_notifications (id, description, counselor_name, time, event_start, location, event_end, event_date) VALUES (?, ?, ?, NOW(), ?, ?, ?, ?)";
        $stmt = $conn->prepare($sqlQ);
        $stmt->bind_param("issssss", $student_id, $notif_desc, $counselor_name, $time_from, $location, $time_to, $date);
        $notif_desc = "Your appointment has been confirmed";
        $insert = $stmt->execute();

        // Insert data into the database 
        $sqlQ = "UPDATE events SET counselor_name=?, counselor_email=?, status=? WHERE id=?";
        $stmt = $conn->prepare($sqlQ);
        $stmt->bind_param("sssi", $counselor_name, $counselor_email, $db_status, $db_userID);
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