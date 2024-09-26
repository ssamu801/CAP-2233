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
    .notifs {
        background-color: #f8f9fa !important; /* Default background color for read notifications */
        cursor: pointer;
    }
    .unread {
        background-color: #e0ffe0 !important; /* Background color for unread notifications */
        cursor: pointer;
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
                // SQL query to select data based on ID
                $sql = "SELECT id, posterID, time, type, topic_id, comment_id, event_id, content, is_read
                        FROM notifications
                        WHERE posterID = $id
                        ORDER BY time DESC;";
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
                                return "Google Calendar Event for Online Appointment";
                            case 11:
                                return "Student Booked an Appointment";
                            case 12: 
                                return "New post from category followed";   
                            case 13:
                                return "Appointment Cancelled"; 
                            case 14:
                                return "Request for Preferred Counselor Approved";
                            case 15:
                                return "Request for Preferred Counselor Declined";            
                            default:
                                return "Notification";
                        }
                    }

                    while ($row = $result->fetch_assoc()) {
                         $isReadClass = $row['is_read'] ? '' : 'unread';
                    ?>
                        <div class="p-3 d-flex align-items-center bg-light border-bottom osahan-post-header notifs <?php echo $isReadClass; ?>"
                                    data-id="<?php echo $row['id'];?>"
                                    data-event-id="<?php echo $row['event_id'];?>"
                                    data-topic-id="<?php echo $row['topic_id'];?>"
                                    data-comment-id="<?php echo $row['comment_id'];?>"
                                    data-type="<?php echo $row['type'];?>">
                            <div class="dropdown-list-image mr-3">
                                <img class="rounded-circle" src="https://bootdey.com/img/Content/avatar/avatar3.png" alt="" />
                            </div>
                            <div class="font-weight-bold mr-3">
                                <?php 
                                    $title = getNotificationTitle($row['type']);
                                    $description = truncateString($row['content'], 100);
                                ?>
                                <div class="text-truncate"><?php echo $title?></div>
                                <div class="small"><?php echo $description?></div>
                            </div>
                            <span class="ml-auto mb-auto">
                                <br />
                                <div class="text-right text-muted pt-1"><?php echo daysFromCurrentDate($row['time']) ?>d</div>
                            </span>
                        </div>

                    <?php
                    }
                } else {
                    echo "You currently have no notifications";
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

// $('.notification_record').click(function(){
//     // alert("HELLO");
//     var id = $(this).attr('data-id');
//     var topic_id = $(this).attr('data-topic_id');
//     var event_id = $(this).attr('data-event_id');
//     var comment_id = $(this).attr('data-comment_id');
//     var type = $(this).attr('data-type');
//     view_modal("Notification (ID: " + dataId + ")", "./notifications/notification_modal.php?id="+id+"&topic_id="+topic_id+"&event_id="+event_id+"&comment-id="+comment_id+"&type="+type, 'large');	
// });

$('.notifs').click(function(){
    var id = $(this).attr('data-id');
    var topic_id = $(this).attr('data-topic-id');
    var event_id = $(this).attr('data-event-id');
    var comment_id = $(this).attr('data-comment-id');
    var type = $(this).attr('data-type');
    var notifElement = $(this); // Store the clicked element reference

    // Update the notification as read in the database
    $.ajax({
        url: 'ajax.php?action=mark_as_read', // Create this PHP file to handle the update
        method: 'POST',
        data: { id: id },
        success: function(response) {
            // Change the background color to the default once clicked
            notifElement.removeClass('unread');
        }
    });

    view_modal("Notification (ID: " + id + ")", "./notifications/notification_modal.php?id="+id+"&topic_id="+topic_id+"&event_id="+event_id+"&comment_id="+comment_id+"&type="+type, 'large');
});


</script>