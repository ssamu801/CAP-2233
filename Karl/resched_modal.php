<?php
session_start();
 $id = $_GET['id'];
 $login_id = $_SESSION['login_id'];
 include '../db_connect.php';
 $requests = $conn->query("SELECT *
                             FROM events 
                             WHERE id = $id LIMIT 1;");
    while($row= $requests->fetch_assoc()):
?>
<form method='post' action='appointments/send.php'> 
    <input type='hidden' id='counselor_email' name='counselor_email' value='<?php echo $_SESSION['login_email']; ?>'>
    <input type='hidden' id='counselor_name' name='counselor_name' value='<?php echo $_SESSION['login_name']; ?>'>
    <input type='hidden' id='student_id' name='student_id' value='<?php echo $row['student_id']; ?>'>
    <input type='hidden' id='userID' name='userID' value='<?php echo $row['id']; ?>'>
    <input type='hidden' value='<?php echo $row['user_email']; ?>' name='user_email'>
    <input type='hidden' value='<?php echo $row['user_name']; ?>' name='user_name'>
    <input type='hidden' value='<?php echo $row['title']; ?>' name='title'>
    <input type='hidden' value='<?php echo $row['date']; ?>' name='date'>
    <input type='hidden' value='<?php echo $row['time_from']; ?>' name='time_from'>
    <input type='hidden' value='<?php echo $row['time_to']; ?>' name='time_to'>
    <input type='hidden' value='<?php echo $row['location']; ?>' name='location'>
    <input type='hidden' value='<?php echo $row['counselor_id']; ?>' name='counselor_id'>
    <input type='hidden' value='Reschedule' name='action'>

    <label>Message to <?php echo $row['user_name']; ?>:</label>
    <textarea class="form-control" name="message" rows="4" cols="50" ></textarea>
    <br>
    <span class="float-right mr-1">
        <input class="btn btn-success ml-2 text-white" type='submit' name='Accept' value='Send'/>
        <button type="button" class="btn ml-2 btn-secondary" data-dismiss="modal">Cancel</button>
    </span>
</form>    
    <?php endwhile; ?>
