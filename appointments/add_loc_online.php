<?php
$id = $_GET['resp'];
$login_id = $_SESSION['login_id'];
include './db_connect.php';
$requests = $conn->query("SELECT *
                         FROM events 
                         WHERE id = $id LIMIT 1;");
while($row = $requests->fetch_assoc()):
?>
<form id='autoSubmitForm' method='post' action='index.php?page=appointments/addevent'> 
    <input type='hidden' id='event_id' name='event_id' value='<?php echo $id; ?>'>
    <input type='hidden' id='counselor_email' name='counselor_email' value='<?php echo $row['counselor_email']; ?>'>
    <input type='hidden' id='counselor_name' name='counselor_name' value='<?php echo $row['counselor_name']; ?>'>
    <input type='hidden' id='counselor_id' name='counselor_id' value='<?php echo $row['counselor_id']; ?>'>
    <input type='hidden' id='student_id' name='student_id' value='<?php echo $row['student_id']; ?>'>
    <input type='hidden' id='userID' name='userID' value='<?php echo $row['id']; ?>'>
    <input type='hidden' value='<?php echo $row['user_email']; ?>' name='user_email'>
    <input type='hidden' value='<?php echo $row['user_name']; ?>' name='user_name'>
    <input type='hidden' value='<?php echo $row['title']; ?>' name='title'>
    <input type='hidden' value='<?php echo $row['date']; ?>' name='date'>
    <input type='hidden' value='<?php echo $row['time_from']; ?>' name='time_from'>
    <input type='hidden' value='<?php echo $row['time_to']; ?>' name='time_to'>
    <input type='hidden' value='To be provided' name='location'>
    <input type='hidden' type=submit value='Accept' name='Accept'>

</form>    
<?php endwhile; ?>

<script>
    window.onload = function() {
        document.getElementById('autoSubmitForm').submit();
    };
</script>

<?php
/* Changes as of 7/8/2024
    Main changes: Added student id to query, added hidden input for student id, username, and user email.
   Lines added: 
	6
	20
	22-23

   End of Changes*/
?>
