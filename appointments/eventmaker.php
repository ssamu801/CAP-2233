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
        <div class="form-group">
            <label>Event Title</label>
            <input type="text" class="form-control" name="title" value="" required>
        </div>
        <div class="form-group">
            <label>Event Description</label>
            <textarea name="description" class="form-control" required></textarea>
        </div>
        <div class="form-group">
            <label>Location</label>
            <input type="text" name="location" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Client Name</label>
            <input type="text" name="client_name" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Client Email</label>
            <input type="text" name="attendees" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Date</label>
            <input type="date" name="date" class="form-control" required>
        </div>
        <div class="form-group time">
            <label>Starting Time</label>
            <input type="time" name="time_from" class="form-control" value="<?php echo !empty($postData['time_from'])?$postData['time_from']:''; ?>" required>
            <span>Ending Time</span>
            <input type="time" name="time_to" class="form-control" value="<?php echo !empty($postData['time_to'])?$postData['time_to']:''; ?>" required>
        </div>
        <div class="form-group">
            <input type="submit" class="form-control navbar-color" name="submit" value="Add Event"/>
        </div>
    </form>
</div>

		
</body>
</html>
