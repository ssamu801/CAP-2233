<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

include '../db_connect.php';

if($_POST['action'] == 'Cancel'){

	$sqlQ = "UPDATE event_notifications SET event_status=? WHERE notif_id=?";
	$stmt = $conn->prepare($sqlQ);
	$stmt->bind_param("si", $db_status, $db_userID);
	$db_status = "Cancelled";
	$db_userID = $userID;
	$insert = $stmt->execute();

	$mail = new PHPMailer(true);
	$mail->Host = 'smtp.gmail.com';
	$mail->SMTPAuth = true;
	$mail->Username = 'karl_casingal@dlsu.edu.ph';
	$mail->Password = 'yedqigenkuorqaie';
	$mail->SMTPSecure = 'ssl';
	$mail->Port = 465;

	$mail->setFrom('karl_casingal@dlsu.edu.ph');

	$mail->addAddress("karlcasingal17@gmail.com");

	$mail->isSMTP(true);

	$mail->Subject = "Missed Appointment from OCCSasdasdasdasdasdasd";

	$mail->Body = "We would like to inform you that you have missed your scheduled appointment with the OCCS.";

	$mail->send();

	echo
	"
	<script>
	alert('Appointment has been cancelled. User has been notified of cancellation.');
	document.location.href = '/index.php?page=appointments/pendingappointments';
	</script>
	";
}

/* OLD VERSION FROM email.php
if(isset($_POST["send"])){
	$mail = new PHPMailer(true);
	$mail->Host = 'smtp.gmail.com';
	$mail->SMTPAuth = true;
	$mail->Username = 'karl_casingal@dlsu.edu.ph';
	$mail->Password = 'yedqigenkuorqaie';
	$mail->SMTPSecure = 'ssl';
	$mail->Port = 465;

	$mail->setFrom('karl_casingal@dlsu.edu.ph');

	$mail->addAddress($_POST["email"]);

	$mail->isSMTP(true);

	$mail->Subject = $_POST["subject"];

	$mail->Body = $_POST["message"];

	$mail->send();

	echo
	"
	<script>
	alert('Sent Successfully');
	document.location.href = '/index.php?page=appointments/email';
	</script>
	";
}
*/

?>