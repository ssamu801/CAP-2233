<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/5.3.45/css/materialdesignicons.css" integrity="sha256-NAxhqDvtY0l4xn+YVa6WjAcmd94NNfttjNsDmNatFVc=" crossorigin="anonymous" />
<style>
    .dropdown-list-image {
        position: relative;
        height: 2.5rem;
        width: 2.5rem;
    }

    .dropdown-list-image img {
        height: 2.5rem;
        width: 2.5rem;
    }

    .btn-light {
        color: #2cdd9b;
        background-color: #e5f7f0;
        border-color: #d8f7eb;
    }
</style>

<br>
<div class="container">
    <!-- <div class="row"> -->
    <div class="col-lg-10 right">
        <div class="box shadow-sm rounded bg-white mb-3">
            <div class="box-title border-bottom p-3">
                <h6 class="m-0">Notifications</h6>
            </div>
            <div class="box-body p-0">

                <?php

                /**
                 * Truncate a string to a specified length and append an ellipsis if necessary.
                 *
                 * @param string $text The string to be truncated.
                 * @param int $limit The maximum number of characters to display.
                 * @return string The truncated string with ellipsis appended if truncated.
                 */
                function truncateString($text, $limit) {
                    if (strlen($text) > $limit) {
                        return substr($text, 0, $limit) . "...";
                    } else {
                        return $text;
                    }
                }

                /**
                 * Calculate the number of days from the current date to the specified date.
                 *
                 * @param string $datetime The target datetime in the format "YYYY-MM-DD HH:MM:SS".
                 * @return int The number of days between the current date and the specified date.
                 */
                function daysFromCurrentDate($datetime) {
                    // Create DateTime objects for the current date and the specified date
                    $currentDate = new DateTime();
                    $targetDate = new DateTime($datetime);

                    // Calculate the difference between the two dates
                    $interval = $currentDate->diff($targetDate);

                    // Return the number of days (use abs to get the absolute value)
                    return $interval->days * ($interval->invert ? -1 : 1);
                }

                // CHECKING CONTENTS OF SESSION
                // echo "<h3> PHP List All Session Variables</h3>";
                // foreach ($_SESSION as $key=>$val)
                // echo $key." ".$val."<br/>";


                include "./db_connect.php";
                $id = $_SESSION['login_id'];
                $id = '12067890';
                // SQL query to select data based on ID
                $sql = "SELECT n.id, n.posterID, n.time, n.type, n.topic_id, n.comment_id, n.event_id, 
                               e.title, e.description, e.mode, e.location, e.date, e.time_from, e.time_to,
                               e.created, e.user_name, e.user_email, e.status, e.student_id, e.isPreferred,
                               e.preferredCounselor, e.counselor_name, e.counselor_email
                        FROM notifications n
                        JOIN events e ON n.event_id = e.id
                        WHERE posterID = $id;";

                $stmt = $conn->prepare($sql);

                // $id = $_SESSION['login_id'];
                // $stmt->bind_param("i", $id); // "i" indicates the type (integer)
                
                // Execute the query
                $stmt->execute();

                // Get the result
                $result = $stmt->get_result();

                // Check if there is a result and process it
                if ($result->num_rows > 0) {
                    // Output data of the row
                    // while ($row = $result->fetch_assoc()) {
                    //     echo "id: " . $row["id"] . " - Name: " . $row["firstname"] . " " . $row["lastname"] . "<br>";
                    // }

                    function getNotificationTitle($type) {
                        switch ($type) {
                            case 1:
                                return "Post Approved";
                            case 2:
                                return "Post Declined";
                            case 3:
                                return "Comment Approved";
                            case 4:
                                return "Comment Declined";
                            case 5:
                                return "New Comment on Your Post";
                            case 6:
                                return "Appointment Submission Confirmed";
                            case 7:
                                return "Appointment Cancelled";
                            case 8:
                                return "Counselor Requested to Reschedule";
                            case 9:
                                return "Reschedule Notification";
                            case 10:
                                return "Zoom Meeting Scheduled";
                            case 11:
                                return "Student Booked an Appointment (Counselor)";
                            default:
                                return "Notification";
                        }
                    }
                    
                    // function truncateString($string, $length) {
                    //     if (strlen($string) <= $length) {
                    //         return $string;
                    //     }
                    //     return substr($string, 0, $length) . '...';
                    // }

                    while ($row = $result->fetch_assoc()) {
                    ?>
                        <div class="p-3 d-flex align-items-center bg-light border-bottom osahan-post-header">
                            <div class="dropdown-list-image mr-3">
                                <img class="rounded-circle" src="https://bootdey.com/img/Content/avatar/avatar3.png" alt="" />
                            </div>
                            <div class="font-weight-bold mr-3 notification_record" data-id="<?php echo $row['id'];?>">
                                <?php 
                                    $title = getNotificationTitle($row['type']);
                                    $description = truncateString($row['description'], 100);
                                ?>
                                <div class="text-truncate"><?php echo $title?></div>
                                <div class="small"><?php echo $description?></div>
                            </div>
                            <span class="ml-auto mb-auto">
                                <!-- <div class="btn-group">
                                    <button type="button" class="btn btn-light btn-sm rounded" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="mdi mdi-dots-vertical"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <button class="dropdown-item" type="button"><i class="mdi mdi-delete"></i> Delete</button>
                                        <button class="dropdown-item" type="button"><i class="mdi mdi-close"></i> Turn Off</button>
                                    </div>
                                </div> -->
                                <br />
                                <div class="text-right text-muted pt-1"><?php echo daysFromCurrentDate($row['time']) ?>d</div>
                            </span>
                        </div>

                    <?php
                    }
                } else {
                    echo "0 results";
                }

                // Close the statement and connection
                $stmt->close();
                $conn->close();

                ?>
        </div>
    </div>
    <!-- </div> -->
</div>

<script>

// function view_modal(heading, url, size) {
//         // Get the modal element
//         var modal = $('#dateModal');

//         // Set the modal title
//         modal.find('.modal-title').text(heading);

//         // Load the content of cal.php into the modal body
//         modal.find('.modal-body').load(url, function() {
//             // Adjust the modal size based on the 'size' parameter
//             if (size === 'mid-large') {
//                 modal.find('.modal-dialog').removeClass('modal-sm').addClass('modal-lg');
//             } else if (size === 'small') {
//                 modal.find('.modal-dialog').removeClass('modal-lg').addClass('modal-sm');
//             } else {
//                 modal.find('.modal-dialog').removeClass('modal-sm modal-lg');
//             }
//         });

//         // Show the modal
//         modal.modal('show');
// }

$('.notification_record').click(function(){
    var dataId = $(this).attr('data-id');
    view_modal("Notification (ID: " + dataId + ")", "./notifications/notification_modal.php?id="+dataId, 'large');	
});

</script>