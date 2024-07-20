<?php 
    include "../db_connect.php";
    error_reporting(E_ERROR | E_PARSE);
    session_start(); // Ensure session is started
    $id = $_SESSION['login_id'];
    $nID = $_GET['id'];
    $event_id = $_GET['event_id'];
    $topic_id = $_GET['topic_id'];
    $comment_id = $_GET['comment_id'];
    $type = $_GET['type'];

    echo "Notification ID: $nID<br>";
    echo "Event ID: $event_id<br>";
    echo "Topic ID: $topic_id<br>";
    echo "Comment ID: $comment_id<br>";
    echo "Type: $type<br>";

    if ($type == 1 || $type == 2) {
        // Post ID will be used
        $sql = "SELECT id, category_ids, title, content, user_id, isAnonymous,
                        date_created, status, date_approved, reviewed_by, reason
                FROM topics
                WHERE id=?";
        // SQL query to select data based on ID
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $topic_id);
        $stmt->execute();
        // Get the result
        $result = $stmt->get_result();
        $row = $result->fetch_assoc(); ?>

        <div class="email-desc-wrapper">
            <div class="email-body">
                <p>Hi!</p>
                <div>
                    <?php 
                        if ($type == 1) { ?>
                            <h1>Your Post Has Been Approved</h1>
                            <p>Your post has been approved. Here are the details:</p>
                            <p><strong>Title:</strong> <?php echo htmlspecialchars($row['title']); ?></p>
                            <p><strong>Content:</strong></p>
                            <div style='border: 1px solid #ccc; padding: 10px;'><?php echo htmlspecialchars($row['content']); ?></div>
                            <br><p>Thank you for contributing to our community!</p>
                        <?php } else if ($type == 2) { ?>
                            <h1>Your Post Has Been Declined</h1>
                            <p>Unfortunately, your post has been declined. Here are the details:</p>
                            <p><strong>Title:</strong> <?php echo htmlspecialchars($row['title']); ?></p>
                            <p><strong>Content:</strong></p>
                            <div style='border: 1px solid #ccc; padding: 10px;'><?php echo htmlspecialchars($row['content']); ?></div>
                            <br><p><strong>Reason for Decline:</strong> <?php echo htmlspecialchars($row['reason']); ?></p>
                            <br><p>Please review our community guidelines and consider revising your post before resubmitting. If you have any questions, feel free to contact us.</p>
                    <?php } ?>
                </div>
            </div>
        </div>
    <?php 
    } else if ($type == 3 || $type == 4 || $type == 5) {
        // Comment ID will be used
        if ($type == 5) {
            $sql = "SELECT t.title, t.content, c.comment, u.name 
                    FROM notifications n 
                    JOIN comments c ON n.comment_id=c.id 
                    JOIN topics t ON n.topic_id=t.id 
                    JOIN users u ON u.id=c.user_id 
                    WHERE n.id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $nID);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result && $result->num_rows > 0) {
                $row = $result->fetch_assoc();
                ?>
                <h1><?php echo $row['name']?> commented on your post.</h1>
                <p>Here are the details:</p>
                <p><strong>Title:</strong> <?php echo htmlspecialchars($row['title']); ?></p>
                <p><strong>Content:</strong></p>
                <div style='border: 1px solid #ccc; padding: 10px;'><?php echo htmlspecialchars($row['content']); ?></div>
                <p class=mt-3><strong>Comment:</strong></p>
                <div style='border: 1px solid #ccc; padding: 10px;'><?php echo htmlspecialchars($row['comment']); ?></div>
               
        <?php }
        } else if ($type == 3 || $type == 4) {
            $sql = "SELECT id, topic_id, user_id, comment, date_created, date_updated, status, date_approved, reviewed_by
                    FROM comments
                    WHERE id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $comment_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $CommentRow = $result->fetch_assoc();

            $topicId = $CommentRow['topic_id'];
            $sqlTopic = "SELECT id, category_ids, title, content, user_id, isAnonymous,
                        date_created, status, date_approved, reviewed_by, reason
                        FROM topics
                        WHERE id=?";
            $stmtTopic = $conn->prepare($sqlTopic);
            $stmtTopic->bind_param("i", $topicId);
            $stmtTopic->execute();
            $resultTopic = $stmtTopic->get_result();
            $TopicRow = $resultTopic->fetch_assoc();

            if ($type == 3) { ?>
                <h1>Your Comment Has Been Approved</h1>
                <p>Your comment has been approved. Here are the details:</p>
                <p><strong>Title:</strong> <?php echo htmlspecialchars($TopicRow['title']); ?></p>
                <p><strong>Content:</strong></p>
                <div style='border: 1px solid #ccc; padding: 10px;'><?php echo htmlspecialchars($TopicRow['content']); ?></div>
                <p><strong>Comment:</strong></p>
                <div style='border: 1px solid #ccc; padding: 10px;'><?php echo htmlspecialchars($CommentRow['comment']); ?></div>
                <br><p>Thank you for contributing to our community!</p>
            <?php } else if ($type == 4) { ?>
                <h1>Your Comment Has Been Declined</h1>
                <p>Unfortunately, your comment has been declined. Here are the details:</p>
                <p><strong>Title:</strong> <?php echo htmlspecialchars($TopicRow['title']); ?></p>
                <p><strong>Content:</strong></p>
                <div style='border: 1px solid #ccc; padding: 10px;'><?php echo htmlspecialchars($TopicRow['content']); ?></div>
                <p><strong>Comment:</strong></p>
                <div style='border: 1px solid #ccc; padding: 10px;'><?php echo htmlspecialchars($CommentRow['comment']); ?></div>
                <br><p><strong>Reason for Decline:</strong> <?php echo htmlspecialchars($TopicRow['reason']); ?></p>
                <br><p>Please review our community guidelines and consider revising your post before resubmitting. If you have any questions, feel free to contact us.</p>
            <?php } 
        }
    } else if ($type == 6) {
        $sql = "SELECT title, e.description, mode, location, date, time_from, time_to,
                       created, e.user_name, user_email, status, student_id, isPreferred,
                       preferredCounselor, counselor_name, counselor_email
                FROM events e
                WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $event_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        $time_from = DateTime::createFromFormat('H:i:s', $row['time_from']);
        $time_to = DateTime::createFromFormat('H:i:s', $row['time_to']); ?>

        <div class="email-desc-wrapper">
            <div class="email-body">
                <p>Your appointment has been successfully submitted and confirmed. Here are the details of your appointment:</p>
                <ul>
                    <li><strong>Counselor Name:</strong> <?php echo htmlspecialchars($row['counselor_name']); ?> </li>
                    <li><strong>Date:</strong> <?php echo htmlspecialchars($row['date']); ?></li>
                    <li><strong>Mode:</strong> <?php echo htmlspecialchars($row['mode']); ?></li>
                    <li><strong>Time:</strong> <?php echo $time_from->format('g:i A') . " to " . $time_to->format('g:i A'); ?></li>
                    <?php if(!empty($row['location'])):?>
                    <li><strong>Location:</strong> <?php echo htmlspecialchars($row['location']); ?></li>
                    <?php else:?>
                    <li><strong>Location:</strong> Zoom link for session will be provided by the counselor.</li>
                    <?php endif;?>
                </ul>
                <?php if(!empty($row['location'])):?>
                <p>Please ensure to arrive at the location at least 10 minutes before your scheduled time. If you need to reschedule or cancel your appointment, please contact us at [Contact Information].</p>
                <?php else:?>
                <p>You will be notified once counselor has provided the Zoom Link. If you need to reschedule or cancel your appointment, please contact us at [Contact Information].</p>
                <?php endif;?>
                <p>Thank you for choosing our services. We look forward to seeing you.</p>
            </div>
        </div>
    <?php } 
    else if ($type == 12) {
        $sql = "SELECT n.topic_id, t.title, t.content, t.isAnonymous, u.name, n.content AS notif_content
        FROM notifications n 
        JOIN topics t ON n.topic_id=t.id 
        JOIN users u ON u.id=t.user_id
        WHERE n.id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $nID);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc(); // Fetch the row data
        ?>
            <h1><?php echo htmlspecialchars($row['notif_content']); ?></h1>
            <div class="mb-1">Here are the details:</div>
            <strong>Title:</strong> <?php echo htmlspecialchars($row['title']); ?><br>
            <?php 
                if ($row['isAnonymous'] == 1) {
                    echo "<p><i>Posted by: Anonymous</i></p>";
                } else {
                    echo "<p><i>Posted by: " . htmlspecialchars($row['name']) . "</i></p>";
                }
            ?>
            <p><strong>Content:</strong></p>
            <div style='border: 1px solid #ccc; padding: 10px;'><?php echo htmlspecialchars($row['content']); ?></div>
            <div><a href="index.php?page=social_interaction/view_forum&id=<?php echo htmlspecialchars($row['topic_id']); ?>">Go to post</a></div>
    <?php }
    }
    else if($type == 11){
        $sql = "SELECT title, e.description, mode, location, date, time_from, time_to,
                       created, e.user_name, user_email, status, student_id, isPreferred,
                       preferredCounselor, counselor_name, counselor_email
                FROM events e
                WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $event_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        $time_from = DateTime::createFromFormat('H:i:s', $row['time_from']);
        $time_to = DateTime::createFromFormat('H:i:s', $row['time_to']); 
        ?>

        <div class="email-desc-wrapper">
            <div class="email-body">
                <p><?php echo htmlspecialchars($row['user_name']); ?> Booked for an appointment.  Here are the details of the appointment:</p>
                <ul>
                    <li><strong>Date:</strong> <?php echo htmlspecialchars($row['date']); ?></li>
                    <li><strong>Mode:</strong> <?php echo htmlspecialchars($row['mode']); ?></li>
                    <li><strong>Time:</strong> <?php echo $time_from->format('g:i A') . " to " . $time_to->format('g:i A'); ?></li>
                    <?php if(!empty($row['location'])):?>
                    <li><strong>Location:</strong> <?php echo htmlspecialchars($row['location']); ?></li>
                    <?php else:?>
                    <li><strong>Location:</strong> Please provide a Zoom link in the <a href="./index.php?page=appointments/pendingappointments">Appointments page</a></li>
                    <?php endif;?>
                </ul>
            </div>
        </div>
    <?php    
    } 
?>


<div class="email-desc-wrapper">
    <div class="email-body">
        <!-- <p>Hi!</p> -->

        <?php //while ($row = $result->fetch_assoc()) { 
            // Appointment Confirmed
            // if($row['type'] == '6') { 
            //     $time_from = DateTime::createFromFormat('H:i:s', $row['time_from']);
            //     $time_to = DateTime::createFromFormat('H:i:s', $row['time_to']);
        ?>
        <!-- <div>
            <p>Your appointment has been successfully submitted and confirmed. Here are the details of your appointment:
            </p>
            <ul>
                <li><strong>Counselor Name:</strong><?php //echo $row['counselor_name']?> </li>
                <li><strong>Date:</strong> <?php //echo $row['date']?></li>
                <li><strong>Time:</strong> <?php //echo $time_from->format('g:i A')." to ".$time_to->format('g:i A')?>
                </li>
                <li><strong>Location:</strong> <?php //echo $row['location']?></li>
            </ul>
            <p>Please ensure to arrive at the location at least 10 minutes before your scheduled time. If you need to
                reschedule or cancel your appointment, please contact us at [Contact Information].</p>
            <p>Thank you for choosing our services. We look forward to seeing you.</p>
        </div> -->
        <?php// } ?>
    </div>
</div>