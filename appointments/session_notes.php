<?php
include '../db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $session_id = $_POST['session_id'];
    $notes = $_POST['notes'];
    $login_id = $_SESSION['login_id'];

    $conn->query("INSERT INTO session_notes (session_id, notes, session_date, assigned_counselor) VALUES ('$session_id', '$notes', NOW(), $login_id) ON DUPLICATE KEY UPDATE notes='$notes'");

    // Redirect back to client_records.php after saving
    header("Location: ../index.php?page=appointments/client_records");
    exit();
}

$session_id = $_GET['id'];
$session = $conn->query("SELECT * FROM events WHERE id = $session_id")->fetch_assoc();
$notes_result = $conn->query("SELECT notes FROM session_notes WHERE session_id = $session_id");
$notes = $notes_result->num_rows > 0 ? $notes_result->fetch_assoc()['notes'] : '';
?>

<div class="container-fluid">
    <form action="appointments/session_notes.php?id=<?php echo $session_id ?>" method="POST">
        <input type="hidden" name="session_id" value="<?php echo $session_id ?>">
        <div class="form-group">
            <label for="student">Student:</label>
            <input type="text" id="student" class="form-control" value="<?php echo $session['user_name'] ?>" readonly>
        </div>
        <div class="form-group">
            <label for="date">Date:</label>
            <input type="text" id="date" class="form-control" value="<?php echo $session['date'] ?>" readonly>
        </div>
        <div class="form-group">
            <label for="time">Time:</label>
            <input type="text" id="time" class="form-control" value="<?php echo date("h:i A", strtotime($session['time_from'])) . " - " . date("h:i A", strtotime($session['time_to'])) ?>" readonly>
        </div>
        <div class="form-group">
            <label for="counselor">Counselor:</label>
            <input type="text" id="counselor" class="form-control" value="<?php echo $session['counselor_name'] ?>" readonly>
        </div>
        <div class="form-group">
            <label for="notes">Session Notes:</label>
            <textarea id="notes" name="notes" class="form-control"><?php echo $notes ?></textarea>
        </div>
        <?php
        // Fetch the student's assessment for this session
        $assessment_result = $conn->query("SELECT mood, progress FROM student_assessments WHERE session_id = $session_id");
        $assessment = $assessment_result->num_rows > 0 ? $assessment_result->fetch_assoc() : null;
        ?>

        <div class="form-group">
            <label for="assessment">Student Assessment:</label>
            <?php if ($assessment): ?>
                <p>Mood: <?php echo $assessment['mood']; ?>/5</p>
                <p>Progress: <?php echo $assessment['progress']; ?>/5</p>
            <?php else: ?>
                <p>No assessment available yet.</p>
            <?php endif; ?>
        </div>

        <button type="submit" class="btn btn-primary">Save Notes</button>
        <button type="button" class="btn btn-secondary" id="backButton">Back</button> <!-- Back button -->
    </form>
</div>

<script>
$(document).ready(function() {
    $('#backButton').on('click', function() {
        $('#dateModal').modal('hide'); // Hide the modal
    });
});
</script>
