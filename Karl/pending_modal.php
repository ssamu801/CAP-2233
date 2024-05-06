<?php
session_start();
 $id = $_GET['id'];
 $login_id = $_SESSION['login_id'];
 include '../db_connect.php';
 $requests = $conn->query("SELECT e.id, e.user_email, e.user_name, e.date, e.location, e.time_from, e.time_to
                             FROM events e
                             JOIN availability a ON e.date = a.date
                             AND e.time_from = a.time_from
                             AND e.time_to = a.time_to
                             WHERE e.status = 'Pending'
                             AND a.status = 'Available'
                             AND a.counselorID = $login_id
                             AND e.id = $id LIMIT 1;");
    while($row= $requests->fetch_assoc()):
?>
<form method='post' action='index.php?page=appointments/addevent'> 
    <input type='hidden' id='counselor_email' name='counselor_email' value='<?php echo $_SESSION['login_email']; ?>'>
    <input type='hidden' id='counselor_name' name='counselor_name' value='<?php echo $_SESSION['login_name']; ?>'>
    <input type='hidden' id='userID' name='userID' value='<?php echo $row['id']; ?>'>
    <input type='hidden' value='<?php echo $row['user_email']; ?>' name='email'>
    <input type='hidden' value='<?php echo $row['title']; ?>' name='title'>
    <input type='hidden' value='<?php echo $row['date']; ?>' name='date'>
    <input type='hidden' value='<?php echo $row['time_from']; ?>' name='time_from'>
    <input type='hidden' value='<?php echo $row['time_to']; ?>' name='time_to'>

    <label>Enter Location/Zoom Link:</label>
    <input type="text" name="location" class="form-control" required>
    <br>
    <span class="float-right mr-1">
        <input class="btn btn-success ml-2 text-white" type='submit' name='Accept' value='Accept'/>
        <button type="button" class="btn ml-2 btn-secondary" data-dismiss="modal">Cancel</button>
    </span>
</form>    
    <?php endwhile; ?>

<?php
/* Changes as of 11:00PM - May 6, 2024

    - Entirely new file

   End of Changes*/
?>