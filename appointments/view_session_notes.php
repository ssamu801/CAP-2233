<?php
session_start();
include '../db_connect.php';

if ($_SESSION['login_type'] != 3) {
    echo '<script type="text/javascript">
    setTimeout(function() {
        window.location.href = "index.php?page=home";
    }, 0000);
    </script>';
    exit();
}

$client_id = $_GET['client_id'];

// Fetch session notes for the given client ID
$session_notes = $conn->query("SELECT sn.session_date, sn.notes 
                               FROM session_notes sn 
                               WHERE sn.user = $client_id 
                               ORDER BY sn.session_date ASC");

?>

<div class="session-notes-container">
    <h4>Session Notes for Client ID: <?php echo $client_id; ?></h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th class="text-center">Session Date</th>
                <th class="text-center">Session Note</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($session_notes->num_rows > 0): ?>
                <?php while ($row = $session_notes->fetch_assoc()): ?>
                    <tr>
                        <td class="text-center"><?php echo $row['session_date']; ?></td>
                        <td><?php echo nl2br($row['notes']); ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="2" class="text-center">No session notes available</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <br>
    <button type="button" class="btn btn-secondary" id="closeModal">Back</button>
</div>

<style>
    .session-notes-container {
        padding: 15px;
    }
    .btn-secondary {
        margin-top: 10px;
    }
</style>

<script>
    document.getElementById('closeModal').onclick = function() {
        // Close the current modal
        $('#dateModal').modal('hide');
    };
</script>
