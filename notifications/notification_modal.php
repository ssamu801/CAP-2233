<?php 
    include "../db_connect.php";
    // $id = $_SESSION['login_id'];
    $id = '12067890';
    $nID = $_GET['id'];
    // SQL query to select data based on ID
    $sql = "SELECT n.id, n.posterID, n.time, n.type, n.topic_id, n.comment_id, n.event_id, 
                   e.title, e.description, e.mode, e.location, e.date, e.time_from, e.time_to,
                   e.created, e.user_name, e.user_email, e.status, e.student_id, e.isPreferred,
                   e.preferredCounselor, e.counselor_name, e.counselor_email
            FROM notifications n
            JOIN events e ON n.event_id = e.id
            WHERE posterID = $id
            AND   n.id = $nID;";

    $stmt = $conn->prepare($sql);

    // $id = $_SESSION['login_id'];
    // $stmt->bind_param("i", $id); // "i" indicates the type (integer)
    
    // Execute the query
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();
?>
<style>

</style>

<div class="email-desc-wrapper">
    <!-- <div class="email-header">
        <div class="email-date">Dec 1, 2019 12:02 PM</div>
        <div class="email-subject">Prepare Mockup as per the spec document and Submit by Monday!!!</div>
        <p class="recipient"><span>From:</span> Paul Smith &lt;paul.smith@domain.com&gt;</p>
    </div> -->
    <div class="email-body">
        <p>Hi!</p>

        <?php while ($row = $result->fetch_assoc()) { 
            if($row['type'] == '6') { 
                $time_from = DateTime::createFromFormat('H:i:s', $row['time_from']);
                $time_to = DateTime::createFromFormat('H:i:s', $row['time_to']);
        ?>
                <div>
                    <p>Your appointment has been successfully submitted and confirmed. Here are the details of your appointment:
                    </p>
                    <ul>
                        <li><strong>Counselor Name:</strong> <?php echo $row['counselor_name']?> </li>
                        <li><strong>Date:</strong> <?php echo $row['date']?></li>
                        <li><strong>Time:</strong> <?php echo $time_from->format('g:i A')." to ".$time_to->format('g:i A')?></li>
                        <li><strong>Location:</strong> <?php echo $row['location']?></li>
                    </ul>
                    <p>Please ensure to arrive at the location at least 10 minutes before your scheduled time. If you need to
                        reschedule or cancel your appointment, please contact us at [Contact Information].</p>
                    <p>Thank you for choosing our services. We look forward to seeing you.</p>
                </div>
            <?php } ?>

        <?php } ?>
    </div>
</div>