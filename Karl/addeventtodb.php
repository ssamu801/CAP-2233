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
    $time_from = !empty($_POST['time_from'])?trim($_POST['time_from']):''; 
    $time_to = !empty($_POST['time_to'])?trim($_POST['time_to']):''; 
    $user_name = !empty($_POST['client_name'])?trim($_POST['client_name']):''; 
    $user_email = !empty($_POST['attendees'])?trim($_POST['attendees']):''; 
    $counselor_name = !empty($_POST['counselor_name'])?trim($_POST['counselor_name']):''; 
    $counselor_email = !empty($_POST['attendees2'])?trim($_POST['attendees2']):''; 
     
    // Validate form input fields 
    if(empty($title)){ 
        $valErr .= 'Please enter event title.<br/>'; 
    } 

     
    // Check whether user inputs are empty 
    if(empty($valErr)){ 
        // Insert data into the database 
        $sqlQ = "INSERT INTO events (title, description, location, date, time_from, time_to, created, user_name, user_email, counselor_email, status) VALUES (?, ?, ?, ?, ?, ?, NOW(), ?, ?, ?, ?)"; 
        $stmt = $conn->prepare($sqlQ); 
        $stmt->bind_param("ssssssssss", $db_title, $db_description, $db_location, $db_date, $db_time_from, $db_time_to, $db_user_name, $db_email1, $db_email2, $db_status); 
        $db_title = $title; 
        $db_description = $description; 
        $db_location = $location; 

        $selected_option = $_POST['time'];
        list($date, $time_from, $time_to) = explode('|', $selected_option);

        $db_time_from = $time_from; 
        $db_time_to = $time_to; 
        $db_date = $date; 
        $db_user_name = $user_name; 
        $db_email1 = $user_email; 
        $db_email2 = $counselor_email; 
        $db_status = "Pending";
        $insert = $stmt->execute(); 
         
        // Check if the insert was successful before redirecting
        if($insert){ 
            // JavaScript for automatic redirect 
            echo '<script type="text/javascript">
                      setTimeout(function() {
                          window.location.href = "index.php?page=appointments/eventmaker";
                      }, 0000); 
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
</script>