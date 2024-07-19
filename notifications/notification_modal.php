<?php 
    include "../db_connect.php";
    $id = $_SESSION['login_id'];
    // $id = '12067890';
    $id = '12039063';
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

    if($type == 1 || $type == 2) {
        //Post ID will be used
        $sql = "SELECT id, category_ids, title, content, user_id, isAnonymous,
                        date_created, status, date_approved, reviewed_by, reason
                FROM topics
                WHERE id=$topic_id";
        // SQL query to select data based on ID
        $stmt = $conn->prepare($sql);
        // Execute the query
        $stmt->execute();
        // Get the result
        $result = $stmt->get_result(); ?>

        <div class="email-desc-wrapper">
        <div class="email-body">
        <p>Hi!</p>

        <?php $row = $result->fetch_assoc()
            // Appointment Confirmed
            // $time_from = DateTime::createFromFormat('H:i:s', $row['time_from']);
            // $time_to = DateTime::createFromFormat('H:i:s', $row['time_to']);
        ?>
        <div>
            <?php 
                if($type == 1) {?>
                    <h1>Your Post Has Been Approved</h1>
                    <p>Your post has been approved. Here are the details:</p>
                    <p><strong>Title:</strong>  <?php echo $row['title'];?></p>
                    <p><strong>Content:</strong></p>
                    <div style='border: 1px solid #ccc; padding: 10px;'><?php echo html_entity_decode($row['content']);?></div>
                    <br><p>Thank you for contributing to our community!</p>
                <?php } else if ($type == 2) { ?>
                    <h1>Your Post Has Been Declined</h1>
                    <p>Unfortunately, your post has been declined. Here are the details:</p>
                    <p><strong>Title:</strong> <?php echo $row['title'];?></p>
                    <p><strong>Content:</strong></p>
                    <div style='border: 1px solid #ccc; padding: 10px;'><?php echo html_entity_decode($row['content']);?></div>
                    <br><p><strong>Reason for Decline:</strong><?php echo $row['reason'];?></p>
                    <br><p>Please review our community guidelines and consider revising your post before resubmitting. If you have any questions, feel free to contact us.</p>
                <?php } ?>
            </div>
    <?php } else if($type == 3 || $type == 4 || $type == 5 || $type == 11) {
        // Comment ID will be used
        if($type == 3 || $type == 4) { 
            $sql = "SELECT id, topic_id, user_id, comment, date_created, date_updated, status, date_approved, reviewed_by
                    FROM comments
                    WHERE id=$comment_id;";
            // SQL query to select data based on ID
            $stmt = $conn->prepare($sql);
            // Execute the query
            $stmt->execute();
            // Get the result
            $result = $stmt->get_result(); 
            $CommentRow = $result->fetch_assoc(); 


            //Post ID will be used
            $topicId = $CommentRow['topic_id'];
            $sqlTopic = "SELECT id, category_ids, title, content, user_id, isAnonymous,
                    date_created, status, date_approved, reviewed_by, reason
                    FROM topics
                    WHERE id=$topicId";
            // SQL query to select data based on ID
            $stmtTopic = $conn->prepare($sqlTopic);
            // Execute the query
            $stmtTopic->execute();
            // Get the result
            $resultTopic = $stmtTopic->get_result();
            $TopicRow = $resultTopic->fetch_assoc(); 
            
            //APPROVED COMMENT
            if($type == 3) { ?>
                <h1>Your Comment Has Been Approved</h1>
                    <p>Your post has been approved. Here are the details:</p>
                    <p><strong>Title:</strong>  <?php echo $TopicRow['title'];?></p>
                    <p><strong>Content:</strong></p>
                    <div style='border: 1px solid #ccc; padding: 10px;'><?php echo html_entity_decode($TopicRow['content']);?></div>
                    <p><strong>Comment:</strong></p>
                    <div style='border: 1px solid #ccc; padding: 10px;'><?php echo html_entity_decode($CommentRow['comment']);?></div>
                    <br><p>Thank you for contributing to our community!</p>
            <?php } else if($type == 4) {?>
                <h1>Your Post Has Been Declined</h1>
                    <p>Unfortunately, your comment has been declined. Here are the details:</p>
                    <p><strong>Title:</strong> <?php echo $TopicRow['title'];?></p>
                    <p><strong>Content:</strong></p>
                    <div style='border: 1px solid #ccc; padding: 10px;'><?php echo html_entity_decode($TopicRow['content']);?></div>
                    <p><strong>Comment:</strong></p>
                    <div style='border: 1px solid #ccc; padding: 10px;'><?php echo html_entity_decode($CommentRow['content']);?></div>
                    <br><p><strong>Reason for Decline:</strong><?php echo $row['reason'];?></p>
                    <br><p>Please review our community guidelines and consider revising your post before resubmitting. If you have any questions, feel free to contact us.</p>
        <?php } else if($type == 5){ ?>

    
    
        <?php } }?> 
    <?php } else if($type == 6) {
        $sql = "SELECT title, e.description, mode, location, date, time_from, time_to,
                       created, e.user_name, user_email, status, student_id, isPreferred,
                       preferredCounselor, counselor_name, counselor_email
                FROM events e
                WHERE id=$event_id;";

        // SQL query to select data based on ID
        $stmt = $conn->prepare($sql);
        // Execute the query
        $stmt->execute();
        // Get the result
        $result = $stmt->get_result();

        $row = $result->fetch_assoc();

        //Appointment Confirmed
        $time_from = DateTime::createFromFormat('H:i:s', $row['time_from']);
        $time_to = DateTime::createFromFormat('H:i:s', $row['time_to']); ?>

        <div>
            <p>Your appointment has been successfully submitted and confirmed. Here are the details of your appointment:
            </p>
            <ul>
                <li><strong>Counselor Name:</strong><?php echo $row['counselor_name']?> </li>
                <li><strong>Date:</strong> <?php echo $row['date']?></li>
                <li><strong>Mode:</strong> <?php echo $row['mode']?></li>
                <li><strong>Time:</strong> <?php echo $time_from->format('g:i A')." to ".$time_to->format('g:i A')?>
                </li>
                <li><strong>Location:</strong> <?php echo $row['location']?></li>
            </ul>
            <p>Please ensure to arrive at the location at least 10 minutes before your scheduled time. If you need to
                reschedule or cancel your appointment, please contact us at [Contact Information].</p>
            <p>Thank you for choosing our services. We look forward to seeing you.</p>
        </div>
     <?php }
?>


<div class="email-desc-wrapper">
    <div class="email-body">
        <!-- <p>Hi!</p> -->

        <?php while ($row = $result->fetch_assoc()) { 
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
        <?php } ?>
    </div>
</div>