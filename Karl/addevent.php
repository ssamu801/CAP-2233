<?php     
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../phpmailer/src/Exception.php';
require '../phpmailer/src/PHPMailer.php';
require '../phpmailer/src/SMTP.php';
// Include database configuration file 
require_once '../db_connect.php'; 
 
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
}else if(isset($_POST['Reschedule'])){ 
    $_SESSION['postData'] = $_POST; 
    $userID = !empty($_POST['userID'])?trim($_POST['userID']):''; 

    $sqlQ = "UPDATE events SET status=? WHERE id =?;"; 
    $stmt = $conn->prepare($sqlQ); 
    $stmt->bind_param("si", $db_status, $db_userID); 
    $db_status = "Rescheduled";
    $db_userID = $userID; 
    $insert = $stmt->execute();

    $userID = !empty($_POST['userID']) ? trim($_POST['userID']) : ''; 
    $student_id = !empty($_POST['student_id']) ? trim($_POST['student_id']) : ''; 
    $counselor_email = !empty($_POST['counselor_email']) ? trim($_POST['counselor_email']) : ''; 
    $counselor_name = !empty($_POST['counselor_name']) ? trim($_POST['counselor_name']) : ''; 
    $counselor_id = !empty($_POST['counselor_id']) ? trim($_POST['counselor_id']) : ''; 
    $user_email = !empty($_POST['user_email']) ? trim($_POST['user_email']) : ''; 
    $user_name = !empty($_POST['user_name']) ? trim($_POST['user_name']) : ''; 
    $location = !empty($_POST['location']) ? trim($_POST['location']) : ''; 
    $time_from = !empty($_POST['time_from']) ? trim($_POST['time_from']) : ''; 
    $time_to = !empty($_POST['time_to']) ? trim($_POST['time_to']) : ''; 
    $date = !empty($_POST['date']) ? trim($_POST['date']) : ''; 
    $user_type = !empty($_POST['user_type']) ? trim($_POST['user_type']) : ''; 

    $notif_desc = "Your appointment needs to be rescheduled. Please reschedule your appointment by clicking this link: <a href='/index.php?page=appointments/eventmaker&counselor_name=" . urlencode($counselor_name) . "&counselor_id=". urlencode($counselor_id) ."'>Reschedule</a>";        
    
    $event_status = "Rescheduled";

    $sqlFetchEmail = "SELECT user_email FROM events WHERE id=?";
    $stmtFetchEmail = $conn->prepare($sqlFetchEmail);
    $stmtFetchEmail->bind_param("i", $userID);
    $stmtFetchEmail->execute();
    $resultFetchEmail = $stmtFetchEmail->get_result();
            
    if ($resultFetchEmail->num_rows > 0) {
        $userEmailRow = $resultFetchEmail->fetch_assoc();
        $userEmail = $userEmailRow['user_email'];
    } else {
        // Handle case where no email is found for the appointment
        echo "<script>
            alert('No email found for the specified appointment.');
            document.location.href = '/index.php?page=appointments/pendingappointments';
            </script>";
        exit;
    }

    $sqlQ = "INSERT INTO event_notifications (id, description, user_email, counselor_name, time, event_start, location, event_end, event_date, event_status, user_name) VALUES (?, ?, ?, ?, NOW(), ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sqlQ);
    $stmt->bind_param("isssssssss", $student_id, $notif_desc, $user_email, $counselor_name, $time_from, $location, $time_to, $date, $event_status, $user_name);
    $insert0 = $stmt->execute();

    $sqlQ2 = "UPDATE events SET status=? WHERE id=?";
    $stmt = $conn->prepare($sqlQ2);
    $stmt->bind_param("si", $db_status, $db_userID);
    $db_status = "Reschedule";
    $db_userID = $userID;
    $insert2 = $stmt->execute();

    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'karl_casingal@dlsu.edu.ph';
    $mail->Password = 'yedqigenkuorqaie';
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;

    $mail->setFrom('karl_casingal@dlsu.edu.ph');
    $mail->addAddress($userEmail);
    $mail->Subject = "Reschedule your Appointment with OCCS";
    $mail->Body = "We would like to ask you to reschedule your appointment with the OCCS. Please view your notifications on our website for more information.";
    $mail->isHTML(true);
    $mail->send();

    if($insert0){ 
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