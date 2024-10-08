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
<form method='post' action='index.php?page=appointments/addevent'> 
    <input type='hidden' id='event_id' name='event_id' value='<?php echo $id; ?>'>
    <input type='hidden' id='counselor_email' name='counselor_email' value='<?php echo $_SESSION['login_email']; ?>'>
    <input type='hidden' id='counselor_name' name='counselor_name' value='<?php echo $_SESSION['login_name']; ?>'>
    <input type='hidden' id='counselor_id' name='counselor_id' value='<?php echo $row['counselor_id']; ?>'>
    <input type='hidden' id='student_id' name='student_id' value='<?php echo $row['student_id']; ?>'>
    <input type='hidden' id='event_id' name='event_id' value='<?php echo $row['id']; ?>'>
    <input type='hidden' value='<?php echo $row['user_email']; ?>' name='user_email'>
    <input type='hidden' value='<?php echo $row['user_name']; ?>' name='user_name'>
    <input type='hidden' value='<?php echo $row['title']; ?>' name='title'>
    <input type='hidden' value='<?php echo $row['date']; ?>' name='date'>
    <input type='hidden' value='<?php echo $row['time_from']; ?>' name='time_from'>
    <input type='hidden' value='<?php echo $row['time_to']; ?>' name='time_to'>
    <input type="hidden" name="cancel_type" value="counselor">
    <input type="hidden" name="posterID" value="<?php echo $login_id?>">

    <label>Enter reason for cancelling:</label>
    <input type="text" name="reason" class="form-control" required>
    <br>
    <span class="float-right mr-1">
        <input class="btn btn-danger ml-2 text-white" type='submit' name='Cancel' value='Cancel'/>
        <button type="button" class="btn ml-2 btn-secondary" data-dismiss="modal">Exit</button>
    </span>
</form>    
    <?php endwhile; ?>

<?php
/* Changes as of 7/8/2024
    Main changes: Added student id to query, added hidden input for student id, username, and user email.
   Lines added: 
	6
	20
	22-23

   End of Changes*/
?>