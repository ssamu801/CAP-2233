<html>
<head>
<meta charset="UTF-8">
	<title>Requests</title>
</head>

<?php 
// Include configuration file 
include_once 'config.php'; 
 
$postData = ''; 
if(!empty($_SESSION['postData'])){ 
    $postData = $_SESSION['postData']; 
    unset($_SESSION['postData']); 
} 
 
$status = $statusMsg = ''; 
if(!empty($_SESSION['status_response'])){ 
    $status_response = $_SESSION['status_response']; 
    $status = $status_response['status']; 
    $statusMsg = $status_response['status_msg']; 
} 
?>

<!-- Status message -->
<?php if(!empty($statusMsg)){ ?>
    <div style='width:50%; margin-left: auto; ; margin-right: auto; padding-bottom: 20px; padding-top: 20px;' class="alert alert-<?php echo $status; ?>"><?php echo $statusMsg; ?></div>
<?php } ?>
<div class="row mb-4 mt-4">
			<div class="col-md-12">
				
			</div>
		</div>
<div class="col-md-12" style='width:50%; margin-left: auto; ; margin-right: auto; padding-bottom: 20px; padding-top: 20px; background-color:#FFFFFF' >
    <form method="post" action="index.php?page=appointments/addeventtodb" class="form">
            <?php

                   include './db_connect.php';
                   $id = $_SESSION['login_id'];
                   $requests = $conn->query("SELECT name, email FROM users where id = '$id';");
                   $total = mysqli_num_rows($requests);
                   if($total > 0):
                       while($row= $requests->fetch_assoc()):
            ?>
                        <input type="hidden" name="client_name" value='<?php echo $row["name"]; ?>'>
                        <input type="hidden" name="attendees" value='<?php echo $row["email"];?>'>
                        <input type="hidden" name="student_id" value='<?php echo $id;?>'>
                        <div class="form-group">
                            <label>Event Title</label>
                            <input type="text" class="form-control" name="title" value='Consultation - <?php echo $row["name"]; ?>' readonly >
                        </div>
                        <div class="form-group">
                            <label>Event Description</label>
                            <input type="text" name="description" class="form-control" value='Consultation with student named <?php echo $row["name"]; ?>, ID<?php echo $id; ?>' readonly ></input>
                        </div>
                    <?php endwhile; ?>
                    <?php endif; ?>
        <div class="form-group ">
            <label>Time</label>
            <select name="time" id="time" class="form-control">
        <?php
                   $text="Example PHP Variable Message";

                   include './db_connect.php';
                   $requests = $conn->query("SELECT date, time_from, time_to, COUNT(*) AS count_occurrences
                                             FROM availability
                                             WHERE status = 'Available'
                                             GROUP BY date, time_from, time_to;");
                   $total = mysqli_num_rows($requests);
                   if($total > 0):
                       while($row= $requests->fetch_assoc()):
        ?>
                <option value='<?php echo $row['date'] . '|' . $row['time_from'] . '|' . $row['time_to']; ?>'>
                  <?php echo date('F j, Y',strtotime($row['date'])); ?> ,
                  <?php echo date("h:i A", strtotime($row['time_from'])); ?> - 
                  <?php echo date("h:i A", strtotime($row['time_to'])); ?>
                </option>
        <?php endwhile; ?>
        <?php endif; ?>
            </select>
        </div>
        <div class="form-group">
            <label>Notes for counselor (Optional)</label>
            <input type="text" name="notes" class="form-control"></input>
        </div>
        <div class="form-group">
            <label>Require urgent assistance: </label>
            <input type="checkbox" id="Urgent" name="urgency" value="Urgent" style="width: 15px; height:15px;">
        </div>
        <div class="form-group">
            <input type="submit" class="form-control navbar-color" name="submit" value="Add Event" style="background-color: #04AA6D;"/>
        </div>
    </form>
</div>

</body>
</html>

<?php
/* Changes as of 11:00PM - May 6, 2024

    - Added lines 36 - 47
    - Changed lines 48 - 80
    - Changed lines 83 - 84
    - Changed lines 87 - 88

   End of Changes*/
?>