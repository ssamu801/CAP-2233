<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../phpmailer/src/Exception.php';
require '../phpmailer/src/PHPMailer.php';
require '../phpmailer/src/SMTP.php';

include '../db_connect.php';

// Check if action is set and process accordingly
if (isset($_POST['action'])) {
    if ($_POST['action'] == 'Cancel') {
        $appointment_id = !empty($_POST['appointment_id']) ? trim($_POST['appointment_id']) : ''; 
        
        // Fetch the user email associated with the appointment
        $sqlFetchEmail = "SELECT user_email FROM events WHERE id=?";
        $stmtFetchEmail = $conn->prepare($sqlFetchEmail);
        $stmtFetchEmail->bind_param("i", $appointment_id);
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

        // Handle cancellation logic
        $sqlQ2 = "UPDATE events SET status=? WHERE id=?";
        $stmt = $conn->prepare($sqlQ2);
        $stmt->bind_param("si", $db_status, $db_userID);
        $db_status = "No Show";
        $db_userID = $appointment_id;
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
        $mail->Subject = "Missed Appointment from OCCS";
        $mail->Body = "We would like to inform you that you have missed your scheduled appointment with the OCCS.";
        $mail->send();

        echo "
        <script>
            alert('Appointment has been cancelled. User has been notified of cancellation.');
            document.location.href = '/index.php?page=appointments/pendingappointments';
        </script>
        ";
    } 

    else {
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

        $notif_desc = "Your appointment needs to be rescheduled. Please reschedule your appointment by clicking this link: <a href='/index.php?page=appointments/eventmaker&counselor_name=" . urlencode($counselor_name) . "&counselor_id=". urlencode($counselor_id) ."'>Reschedule</a>";        
        
        $event_status = "Pending";

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
        $insert = $stmt->execute();

        $sqlQ2 = "UPDATE events SET status=? WHERE id=?";
        $stmt = $conn->prepare($sqlQ2);
        $stmt->bind_param("si", $db_status, $db_userID);
        $db_status = "No Show";
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

        echo "
        <script>
            alert('User has been notified of the need for rescheduling.');
            window.location.href = '../index.php?page=appointments/pendingappointments';
        </script>
        ";
    }
}
?>