<div class="container-fluid">
    <div class="row mb-4 mt-4">
        <div class="col-md-12">
        </div>
    </div>
    <div class="col-lg-12">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <b>Appointments</b>
                        <span class=""></span>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="text-center">Name</th>
                                    <th class="text-center">Email</th>
                                    <th class="text-center">Date</th>
                                    <th class="text-center">Start Time</th>
                                    <th class="text-center">End Time</th>
                                    <th class="text-center">Location</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            <form class="" action="appointments/send.php" method="post">
                            <?php
                            use PHPMailer\PHPMailer\PHPMailer;
                            use PHPMailer\PHPMailer\SMTP;
                            use PHPMailer\PHPMailer\Exception;
                            
                            require 'phpmailer/src/Exception.php';
                            require 'phpmailer/src/PHPMailer.php';
                            require 'phpmailer/src/SMTP.php';
                   
                                $login_id = $_SESSION['login_id'];
                                include './db_connect.php';

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

                                $requests = $conn->query("SELECT id, user_name, user_email, event_date, event_start, event_end, location FROM event_notifications WHERE event_status LIKE 'Pending'");
                                $total = mysqli_num_rows($requests);
                                if($total > 0):
                                    while($row= $requests->fetch_assoc()):
                            ?>
                                    <tr class="client_record record_row" data-id="<?php echo $row['id'] ?>">
				 	                    <td class="text-center">
				 		                    <?php echo $row['user_name'] ?>
				 	                    </td>
				 	                    <td class="text-center">
				 		                    <?php echo$row['user_email'] ?>
				 	                    </td>
                                         <td class="text-center">
				 		                    <?php echo $row['event_date'] ?>
				 	                    </td>
				 	                    <td class="text-center">
				 		                    <?php echo $row['event_start'] ?>
				 	                    </td>
                                         <td class="text-center">
                                            <?php echo $row['event_end'] ?>
				 	                    </td>
                                         <td class="text-center">
                                            <?php echo $row['location'] ?>
				 	                    </td>
                                        <td class="text-center">
                                            <input type="submit" class="btn btn-success text-white" id="complete" name="action" value="Complete" data-id="<?php echo $row['id'] ?>"></input>
                                            <input type="submit" class="btn btn-danger text-white" id="cancel" name="action" value="Cancel" data-id="<?php echo $row['id'] ?>"></input>
                                            <input type="submit" class="btn btn-warning" id="reschedule" name="action" value="Reschedule" data-id="<?php echo $row['id'] ?>"></input>
                                        </td>
                                    
                                    </tr>
                            <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan='6' style='text-align:center;'>There are currently no pending appointments</td>
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

