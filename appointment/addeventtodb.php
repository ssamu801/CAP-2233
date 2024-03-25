<?php     
// Include database configuration file 
require_once 'connect.php'; 
 
$postData = $statusMsg = $valErr = ''; 
$status = 'danger'; 
 
// If the form is submitted 
if(isset($_POST['submit'])){ 
     
    // Get event info 
    $_SESSION['postData'] = $_POST; 
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
        $sqlQ = "INSERT INTO events (title,description,location,date,time_from,time_to,created,email,status) VALUES (?,?,?,?,?,?,NOW(),?,?)"; 
        $stmt = $conn->prepare($sqlQ); 
        $stmt->bind_param("ssssssss", $db_title, $db_description, $db_location, $db_date, $db_time_from, $db_time_to, $db_email, $db_status); 
        $db_title = $title; 
        $db_description = $description; 
        $db_location = $location; 
        $db_date = $date; 
        $db_time_from = $time_from; 
        $db_time_to = $time_to; 
        $db_email =  $email;
        $db_status = "pending";
        $insert = $stmt->execute(); 
         
    }else{ 
        $statusMsg = '<p>Please fill all the mandatory fields:</p>'.trim($valErr, '<br/>'); 
    } 
}

$_SESSION['status_response'] = array('status' => $status, 'status_msg' => $statusMsg); 
 
header("Location: index.php"); 
exit(); 
?>