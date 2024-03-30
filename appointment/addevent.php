<?php     
// Include database configuration file 
require_once 'db_connect.php'; 
 
$postData = $statusMsg = $valErr = ''; 
$status = 'danger'; 
 
// If the form is submitted 
if(isset($_POST['Accept'])){ 
     
    // Get event info 
    $_SESSION['postData'] = $_POST; 
    $userID = !empty($_POST['userID'])?trim($_POST['userID']):''; 
     
    // Check whether user inputs are empty 
    if(empty($valErr)){ 
        // Insert data into the database 
        $sqlQ = "UPDATE events SET status=? WHERE id =?;"; 
        $stmt = $conn->prepare($sqlQ); 
        $stmt->bind_param("si", $db_status, $db_userID); 
        $db_status = "Accepted";
        $db_userID = $userID; 
        $insert = $stmt->execute(); 
        if($insert){ 
            $event_id = $db_userID; 
             
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
}else if(isset($_POST['Reject'])){ 
    $_SESSION['postData'] = $_POST; 
    $userID = !empty($_POST['userID'])?trim($_POST['userID']):''; 

    $sqlQ = "UPDATE events SET status=? WHERE id =?;"; 
    $stmt = $conn->prepare($sqlQ); 
    $stmt->bind_param("si", $db_status, $db_userID); 
    $db_status = "Rejected";
    $db_userID = $userID; 
    $insert = $stmt->execute();

    header("Location: pendingrequests.php"); 
} 
 
$_SESSION['status_response'] = array('status' => $status, 'status_msg' => $statusMsg); 
 
exit(); 
?>
