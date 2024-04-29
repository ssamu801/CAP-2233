<html>

<head>
    <meta charset="UTF-8">
    <title>Requests</title>
</head>

<?php
// Include configuration file 
include_once 'config.php';

$postData = '';
if (!empty($_SESSION['postData'])) {
    $postData = $_SESSION['postData'];
    unset($_SESSION['postData']);
}

$status = $statusMsg = '';
if (!empty($_SESSION['status_response'])) {
    $status_response = $_SESSION['status_response'];
    $status = $status_response['status'];
    $statusMsg = $status_response['status_msg'];
}
?>

<!-- Status message -->
<?php if (!empty($statusMsg)) { ?>
    <div style='width:50%; margin-left: auto; ; margin-right: auto; padding-bottom: 20px; padding-top: 20px;' class="alert alert-<?php echo $status; ?>"><?php echo $statusMsg; ?></div>
<?php } ?>
<div class="row mb-4 mt-4">
    <div class="col-md-12">

    </div>
</div>
<div class="col-md-12" style='width:50%; margin-left: auto; ; margin-right: auto; padding-bottom: 20px; padding-top: 20px; background-color:#FFFFFF'>
    <form method="post" action="index.php?page=appointments/addeventtodb" class="form">
        <div class="form-group">
            <label>Event Title</label>
            <input type="text" class="form-control" name="title" value="INITIAL CONSULTATION: " required>
        </div>
        <!-- <div class="form-group">
            <label>Event Description</label>
            <textarea name="description" class="form-control" required></textarea>
        </div> -->
        <div class="form-group">
            <label>Location</label><br>
            <!-- <input type="text" name="location" class="form-control" required> -->
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="online" onclick="showZoomLinkInput()">
                <label class="form-check-label" for="inlineRadio1">Online</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="face-to-face" onclick="showVenueInput()">
                <label class="form-check-label" for="inlineRadio2">Face-To-Face</label>
            </div>
        </div>
        <div class="form-group" id="zoom_link" style="display: none;">
            <label>Zoom Link</label>
            <input type="text" name="zoom_link" class="form-control" required>
        </div>
        <div class="form-group" id="venue" style="display: none;">
            <label>Venue</label>
            <input type="text" name="venue" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Client Name</label>
            <input type="text" name="client_name" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Client Email</label>
            <input type="text" name="attendees" class="form-control" required>
        </div>
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
            <input type="submit" class="form-control navbar-color" name="submit" value="Add Event" />
        </div>
    </form>
</div>

<script>
    function showZoomLinkInput() {
        document.getElementById("zoom_link").style.display = "block";
        document.getElementById("venue").style.display = "none";
    }

    function showVenueInput() {
        document.getElementById("zoom_link").style.display = "none";
        document.getElementById("venue").style.display = "block";
    }
</script>

</body>

</html>