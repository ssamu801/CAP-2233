<?php
include 'db_connect.php';

// Get the logged-in student ID
$student_id = $_SESSION['login_id'];

// Fetch the list of sessions attended by the student
$sessions = $conn->query("SELECT * FROM events WHERE student_id = $student_id");

?>
<style>
    .container {
        max-width: 1200px;
        margin: 0 auto;
        margin-top: 40px;
        background-color: #ffffff;
        box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
        padding: 20px;
        border-radius: 12px;
    }
    .container h2 {
        font-size: 24px;
        margin-bottom: 20px;
        color: #333;
    }
    .form-group {
        margin-bottom: 20px;
    }
    label {
        display: block;
        font-weight: 600;
        margin-bottom: 8px;
        color: #555;
    }
    input, textarea, select {
        width: 100%;
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-size: 16px;
    }
    button {
        background-color: #007aff;
        color: #fff;
        padding: 12px 20px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-size: 16px;
    }
    button:hover {
        background-color: #005bb5;
    }
    .btn-secondary {
        background-color: #aaa;
    }
    .btn-secondary:hover {
        background-color: #888;
    }
    .completed {
        color: green;
        font-weight: bold;
    }
</style>

<div class="container">
    <h2>My Sessions</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Date</th>
                <th>Time</th>
                <th>Counselor</th>
                <th>Assessment</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = $sessions->fetch_assoc()): ?>
            <?php
            // Check if assessment is completed
            $session_id = $row['id'];
            $assessment_check = $conn->query("SELECT * FROM student_assessments WHERE session_id = $session_id AND completed = 'Yes'");
            $assessment_completed = $assessment_check->num_rows > 0;
            ?>
            <tr>
                <td><?php echo date('F j, Y', strtotime($row['date'])); ?></td>
                <td><?php echo date('h:i A', strtotime($row['time_from'])) . " - " . date('h:i A', strtotime($row['time_to'])); ?></td>
                <td><?php echo $row['counselor_name']; ?></td>
                <td>
                    <?php if ($assessment_completed): ?>
                        <span class="completed">Completed</span>
                    <?php else: ?>
                        <a href="index.php?page=appointments/student_assessment_form&session_id=<?php echo $session_id; ?>" class="btn btn-primary">
                            Fill Assessment
                        </a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>
