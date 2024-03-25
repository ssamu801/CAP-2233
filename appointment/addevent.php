<?php     
// Include database configuration file 
require_once 'connect.php'; 
 
$postData = $statusMsg = $valErr = ''; 
$status = 'danger'; 
 
// If the form is submitted 
if($_POST['Accept'] == "Accept"){ 
     
    // Get event info 
    $_SESSION['postData'] = $_POST; 
    $userID = !empty($_POST['id'])?trim($_POST['id']):''; 
    $title = !empty($_POST['title'])?trim($_POST['title']):''; 
    $description = !empty($_POST['description'])?trim($_POST['description']):''; 
    $location = !empty($_POST['location'])?trim($_POST['location']):''; 
    $date = !empty($_POST['date'])?trim($_POST['date']):''; 
    $time_from = !empty($_POST['time_from'])?trim($_POST['time_from']):''; 
    $time_to = !empty($_POST['time_to'])?trim($_POST['time_to']):''; 
    $email = !empty($_POST['attendees'])?trim($_POST['attendees']):''; 
     
    // Validate form input fields 
    if(empty($title)){ 
        $valErr .= 'Please enter event title.<br/>'; 
    } 
    if(empty($date)){ 
        $valErr .= 'Please enter event date.<br/>'; 
    } 
     
    // Check whether user inputs are empty 
    if(empty($valErr)){ 
        // Insert data into the database 
        $sqlQ = "UPDATE events SET status=? WHERE id =?;"; 
        $stmt = $conn->prepare($sqlQ); 
        $stmt->bind_param("ss", $db_status, $db_userID); 
        $db_status = "Accepted";
        $db_userID = $userID; 
        $insert = $stmt->execute(); 
        
        if($insert){ 
            $event_id = $stmt->insert_id; 
             
            unset($_SESSION['postData']); 
             
            // Store event ID in session 
            $_SESSION['last_event_id'] = $event_id; 
            header("Location: $googleOauthURL"); 
            exit(); 
        }else{ 
            $statusMsg = 'Something went wrong, please try again after some time.'; 
        } 
    }else{ 
        $statusMsg = '<p>Please fill all the mandatory fields:</p>'.trim($valErr, '<br/>'); 
    } 
}else if($_POST['Reject'] == "Reject"){ 
    $statusMsg = 'Form submission failed!';
    header("Location: profile.php"); 
} 
 
$_SESSION['status_response'] = array('status' => $status, 'status_msg' => $statusMsg); 
 
header("Location: index.php"); 
exit(); 
?>