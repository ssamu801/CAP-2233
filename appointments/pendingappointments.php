<!DOCTYPE html>
<html lang="en">
<head>
<?php
// Include configuration and calendar API class files
include './db_connect.php';
require_once 'config.php';
require_once 'calendarapi.class.php';

// Instantiate the GoogleCalendarApi class
$gcal = new GoogleCalendarApi();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reschedule'])) {
    $appointment_id = $_POST['reschedule'];
    echo '<script>alert("Welcome to Geeks for Geeks")</script>'; 
    // Fetch the event ID from the database
    $query = "SELECT google_calendar_event_id FROM events WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $appointment_id);
    $stmt->execute();
    $stmt->bind_result($calendar_event_id);
    $stmt->fetch();
    $stmt->close();

    if (!empty($calendar_event_id)) {
        // Delete the Google Calendar event
        $access_token = $_SESSION['google_access_token'];
        try {
            $gcal->DeleteCalendarEvent($access_token, 'primary', $calendar_event_id);
            echo "Event deleted successfully.";
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }

        // Remove the event ID from the database
        $query = "UPDATE events SET calendar_event_id = NULL WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $appointment_id);
        $stmt->execute();
        $stmt->close();
    }

    // Proceed with your reschedule logic here
    // ...
}
?>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointments</title>
    <style>
        .nav-tabs .nav-link {
            border-bottom-left-radius: .25rem;
            border-bottom-right-radius: .25rem;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
            color: #495057;
            background-color: white;
        }
        .nav-tabs .nav-link.active {
            background-color: #10642c;
            color: white;
        }
        .card-header {
            background-color: #10642c;
            color: white;
        }
        .btn {
            margin: 0 5px;
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row mb-4 mt-4 mx-2">
        <div class="col-md-12">
            <ul class="nav nav-tabs">
                <li class="nav-item mr-1">
                    <a class="nav-link active" href="#f2f" data-toggle="tab">F2F</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#online" data-toggle="tab">Online</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="tab-content">
        <div id="f2f" class="tab-pane fade show active">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <b>Appointments (F2F)</b>
                                <span class=""></span>
                            </div>
                            <div class="card-body">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center">Name</th>
                                            <th class="text-center">Email</th>
                                            <th class="text-center">Date</th>
                                            <th class="text-center">Start Time</th>
                                            <th class="text-center">End Time</th>
                                            <th class="text-center">Location</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <form class="" action="appointments/addevent.php" method="post">
                                    <?php
 use PHPMailer\PHPMailer\PHPMailer;
                                     use PHPMailer\PHPMailer\SMTP;
                                     use PHPMailer\PHPMailer\Exception;
                                     
                                     require 'phpmailer/src/Exception.php';
                                     require 'phpmailer/src/PHPMailer.php';
                                     require 'phpmailer/src/SMTP.php';
                            
                                         $login_id = $_SESSION['login_id'];
                                         include 'db_connect.php';
                                         // For AUTO-MAIL
                                         $results = $conn->query("SELECT *, TIMESTAMPDIFF(day, event_date, NOW()) FROM event_notifications WHERE TIMESTAMPDIFF(day, event_date, NOW()) > 2 AND event_status = 'Pending';");
                                         $automail = mysqli_num_rows($results);
                                         if($automail > 0):
                                             while($row= $results->fetch_assoc()): 
                                                 $sqlQ = "UPDATE event_notifications SET event_status=? WHERE notif_id=?";
                                                 $stmt = $conn->prepare($sqlQ);
                                                 $stmt->bind_param("si", $db_status, $db_userID);
                                                 $db_status = "Cancelled";
                                                 $db_userID = $row['notif_id'];
                                                 $insert = $stmt->execute();
         
                                                 $mail = new PHPMailer(true);
                                                 $mail->Host = 'smtp.gmail.com';
                                                 $mail->SMTPAuth = true;
                                                 $mail->Username = 'karl_casingal@dlsu.edu.ph';
                                                 $mail->Password = 'yedqigenkuorqaie';
                                                 $mail->SMTPSecure = 'ssl';
                                                 $mail->Port = 465;
                                             
                                                 $mail->setFrom('karl_casingal@dlsu.edu.ph');
                                             
                                                 $mail->addAddress($row['user_email']);
                                             
                                                 $mail->isSMTP(true);
                                             
                                                 $mail->Subject = "Missed Appointment from OCCS";
                                             
                                                 $mail->Body = "We would like to inform you that you have missed your scheduled appointment with the OCCS on $row[event_date], $row[event_start] - $row[event_end].";
                                             
                                                 $mail->send();
                                             endwhile;
                                         endif;
         
                                        $requests = $conn->query("SELECT * FROM events WHERE date >= CURDATE() AND counselor_id = $login_id AND status!= 'Reschedule' AND mode = 'Face-to-Face';");
                                        $total = mysqli_num_rows($requests);
                                        if($total > 0):
                                            while($row = $requests->fetch_assoc()):
                                        ?>
                                        <tr class="client_record record_row" data-id="<?php echo $row['id'] ?>">
                                            <form action="appointments/addevent.php" method="post">
                                                <td class="text-center"><?php echo $row['id'] ?></td>
                                                <td class="text-center"><?php echo $row['user_name'] ?></td>
                                                <td class="text-center"><?php echo $row['user_email'] ?></td>
                                                <td class="text-center"><?php echo $row['date'] ?></td>
                                                <input type="hidden" name="userID" value="<?php echo $row['id']; ?>">
                                                <td class="text-center">
                                                    <?php 
                                                    $time_from = $row['time_from'];
                                                    $formatted_time1 = date("h:i A", strtotime($time_from));
                                                    echo $formatted_time1;
                                                    ?>
                                                </td>
                                                <td class="text-center">
                                                    <?php 
                                                    $time_to = $row['time_to'];
                                                    $formatted_time2 = date("h:i A", strtotime($time_to));
                                                    echo $formatted_time2;
                                                    ?>
                                                </td>
                                                <td class="text-center"><?php echo $row['location'] ?></td>
                                                <td class="text-center">
                                                    <?php if ($row['status'] == 'Cancelled'): ?>
                                                        <?php echo "Cancelled"; ?>
                                                    <?php else: ?>    
                                                    <select name="status" class="form-control status-dropdown" data-id="<?php echo $row['id'] ?>">
                                                        <option value="Scheduled" <?php if ($row['status'] == 'Scheduled') echo 'selected'; ?>>Scheduled</option>
                                                        <option value="Completed" <?php if ($row['status'] == 'Completed') echo 'selected'; ?>>Completed</option>
                                                        <option value="No Show" <?php if ($row['status'] == 'No Show') echo 'selected'; ?>>No Show</option>
                                                    </select>
                                                    <?php endif; ?> 
                                                </td>
                                                <td class="text-center">
                                                <?php if ($row['status'] == 'Completed'): ?>
                                                    <?php echo "Completed"; ?>
                                                    <?php elseif ($row['status'] == 'Scheduled'): ?>  
                                                    <input type="submit" class="btn btn-danger text-white" name="action" value="Cancel">
                                                    <button type="button" class="btn btn-warning reschedule-btn" data-id="<?php echo $row['id'] ?>">Reschedule</button>
                                                    <?php else: ?>  
                                                        <?php echo "No actions"; ?>  
                                                    <?php endif; ?>    
                                                </td>
                                            </form>
                                        </tr>
                                        <?php endwhile; ?>
                                        <?php else: ?>
                                        <tr>
                                            <td colspan="8" style="text-align:center;">There are currently no pending appointments</td>
                                        </tr>
                                        <?php endif; ?>
                                    </form>
                                    </tbody>
                                </table>
                            </div>    
                        </div>         
                    </div>     
                </div>   
            </div>
        </div>
        <div id="online" class="tab-pane fade">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <b>Appointments (Online)</b>
                                <span class=""></span>
                            </div>
                            <div class="card-body">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center">Name</th>
                                            <th class="text-center">Email</th>
                                            <th class="text-center">Date</th>
                                            <th class="text-center">Start Time</th>
                                            <th class="text-center">End Time</th>
                                            <th class="text-center">Link</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <form class="" action="appointments/addevent.php" method="post">
                                    <?php
                                    $requests = $conn->query("SELECT * FROM events WHERE date >= CURDATE() AND counselor_id = $login_id AND status!= 'Reschedule' AND mode = 'Online';");
                                    $total = mysqli_num_rows($requests);
                                    if ($total > 0) {
                                        while ($row = $requests->fetch_assoc()) {
                                            ?>
                                            <tr class="client_record record_row" data-id="<?php echo $row['id'] ?>">
                                                <td class="text-center"><?php echo $row['id'] ?></td>
                                                <td class="text-center"><?php echo $row['user_name'] ?></td>
                                                <td class="text-center"><?php echo $row['user_email'] ?></td>
                                                <td class="text-center"><?php echo $row['date'] ?></td>
                                                <td class="text-center"> 
                                                    <?php 
                                                    $time_from = $row['time_from'];
                                                    $formatted_time1 = date("h:i A", strtotime($time_from));
                                                    echo $formatted_time1;
                                                    ?>
                                                </td>
                                                <td class="text-center">
                                                    <?php 
                                                    $time_to = $row['time_to'];
                                                    $formatted_time2 = date("h:i A", strtotime($time_to));
                                                    echo $formatted_time2;
                                                    ?>
                                                </td>
                                                <td class="text-center"><?php 
                                                                            if(!empty($row['location']) || $row['status'] == 'Cancelled'){
                                                                                echo $row['location']; 
                                                                            } else {
                                                                                ?><button id="ACCEPTBTN" class="btn btn-success text-white accept-btn" name="action" id="accept" data-id="<?php echo $row['id'] ?>">Add Link</button><?php
                                                                            }
                                                                            
                                                                        ?>
                                                </td>
                                                <td class="text-center">
                                                    <?php if ($row['status'] == 'Cancelled'): ?>
                                                    <?php echo "Cancelled"; ?>
                                                    <?php else: ?>
                                                    <select name="status" class="form-control status-dropdown" data-id="<?php echo $row['id'] ?>">
                                                        <option value="Scheduled" <?php if ($row['status'] == 'Scheduled') echo 'selected'; ?>>Scheduled</option>
                                                        <option value="Completed" <?php if ($row['status'] == 'Completed') echo 'selected'; ?>>Completed</option>
                                                        <option value="No Show" <?php if ($row['status'] == 'No Show') echo 'selected'; ?>>No Show</option>
                                                    </select>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="text-center">  
                                                    <?php if ($row['status'] == 'Completed'): ?>
                                                    <?php echo "Completed"; ?>
                                                    <?php elseif ($row['status'] == 'Scheduled'): ?>
                                                        <input type="submit" class="btn btn-danger text-white" id="cancel" name="action" value="Cancel" data-id="<?php echo $row['id'] ?>"></input>
                                                        <button id="RESCHEDBTN" class="btn btn-warning reschedule-btn" name="action" id="reschedule" data-id="<?php echo $row['id'] ?>">Reschedule</button>
                                                        <input type="hidden" id="appointment_id" name="appointment_id" value="<?php echo $row['id'] ?>">
                                                    <?php else: ?>  
                                                        <?php echo "No actions"; ?>  
                                                    <?php endif; ?>    
                                                </td>
                                            </tr>
                                            <?php 
                                        } 
                                    } else { 
                                        ?>
                                        <tr>
                                            <td colspan='8' style='text-align:center;'>There are currently no pending appointments</td>
                                        </tr>
                                        <?php 
                                    } 
                                    ?>
                                    </form>
                                    </tbody>
                                </table>
                            </div>    
                        </div>         
                    </div>     
                </div>   
            </div>
        </div>
    </div>
<script>
document.addEventListener('DOMContentLoaded', function() {

    document.addEventListener('click', function(event) {
        if (event.target.classList.contains('accept-btn')) {
            event.preventDefault();
            var appointmentId = event.target.getAttribute('data-id');
            uni_modal2("Accept Appointment Request", "appointments/pending_modal.php?id=" + appointmentId, 'mid-large');
        }
    });

    // Add event listeners to all reschedule buttons with class 'reschedule-btn'
    var rescheduleButtons = document.querySelectorAll('.reschedule-btn');
    
    rescheduleButtons.forEach(function(button) {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            var appointmentId = this.getAttribute('data-id');
            uni_modal2("Reschedule Appointment","appointments/resched_modal.php?id="+$(this).attr('data-id'),'mid-large')
        });
    });

    // AJAX request to update the status
    $('.status-dropdown').change(function() {
        var appointmentId = $(this).data('id');
        var newStatus = $(this).val();

        $.ajax({
            url: 'appointments/update_status.php',
            type: 'POST',
            data: {
                id: appointmentId,
                status: newStatus
            },
            success: function(response) {
                alert_toast(response);
            }
        });
    });
});

</script>


</body>
</html>