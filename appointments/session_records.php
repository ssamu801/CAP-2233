<?php session_start() ?>
<?php
if ($_SESSION['login_type'] != 3) {
    echo '<script type="text/javascript">
    setTimeout(function() {
        window.location.href = "index.php?page=home";
    }, 0000);
    </script>';
}
?>
<table class="table table-striped col-md-12">
    <thead>
        <tr>
            <th class="text-center">Date of Session</th>
            <th class="text-center">Time of Session</th>
            <th class="text-center">Session Type</th>
            <th class="text-center">Location</th>
            <th class="text-center">Status</th>
            <th class="text-center">Urgent</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $user_id = $_GET['id'];
        $clientName = $_GET['clientName'];
        $login_id = $_SESSION['login_id'];
        $userId = $_GET['userId']; // Retrieve the user ID from the URL

        include '../db_connect.php';
        $users = $conn->query("SELECT e.date, e.time_from, e.time_to, e.counselor_name, e.status, e.title, e.location, e.id, e.urgency 
        FROM users u 
        JOIN events e ON u.email = e.user_email 
        WHERE u.id = $user_id
        AND e.counselor_id = $login_id
        AND (e.status = 'Scheduled' OR e.status = 'Completed')
        ORDER BY e.date DESC");

        while ($row = $users->fetch_assoc()):
        ?>
        <tr class="session_record" data-id="<?php echo $row['id']; ?>">
            <td class="text-center"><?php echo $row['date']; ?></td>
            <td class="text-center">
                <?php
                $time_from = date("h:i A", strtotime($row['time_from']));
                $time_to = date("h:i A", strtotime($row['time_to']));
                echo $time_from . " - " . $time_to;
                ?>
            </td>
            <td class="text-center"><?php echo $row['title']; ?></td>
            <td class="text-center"><?php echo $row['location']; ?></td>
            <td class="text-center"><?php echo $row['status']; ?></td>
            <td class="text-center"><?php echo $row['urgency']; ?></td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>
<br>
<div class="button-container">
    <!-- Button to redirect to Change Counselor page -->
    <button class="btn btn-secondary change_counselor" data-id="<?php echo $user_id; ?>" data-id2="<?php echo $clientName; ?>">Change Counselor</button>

    <!-- Button to trigger the modal -->
    <button class="btn btn-primary add_intake_schedule" data-id="<?php echo $user_id; ?>">Add Session Date</button>

    <!-- Button to view all session notes -->
    <button class="btn btn-info view_session_notes" data-id="<?php echo $user_id; ?>">View Session Notes</button>
</div>

<!-- Modal structure -->
<div class="modal fade" id="dateModal" tabindex="-1" role="dialog" aria-labelledby="dateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dateModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Content will be loaded here -->
            </div>
        </div>
    </div>
</div>

<style>
.button-container {
    display: flex;
    justify-content: flex-end;
    gap: 10px; /* Adds space between buttons */
}
</style>

<script>
$(document).ready(function() {
    // Redirect to Change Counselor page
    $(document).on('click', '.change_counselor', function() {
        var dataId = $(this).attr('data-id');
        var dataId2 = $(this).attr('data-id2');
        window.location.href = "index.php?page=appointments/change_counselor_form&user_id=" + dataId + "&clientName=" + dataId2;
    });

    // Load session notes in a modal
    $(document).on('click', '.view_session_notes', function() {
        var dataId = $(this).attr('data-id');
        view_modal("Session Notes", "appointments/view_session_notes.php?client_id=" + dataId, 'large');
    });

    // Handle click event on session records
    $(document).on('click', '.session_record', function() {
        var dataId = $(this).attr('data-id');
        view_modal("Session Record", "appointments/session_notes.php?id=" + dataId, 'large');
    });

    // Handle click event on Add Session Date button
    $(document).on('click', '.add_intake_schedule', function() {
        var dataId = $(this).attr('data-id');
        // Redirect to the specified page with the user ID
        window.location.href = "index.php?page=appointments/counseloreventmaker&user_id=" + dataId;
    });

    $('table').dataTable();

    function view_modal(heading, url, size) {
        var modal = $('#dateModal');
        modal.find('.modal-title').text(heading);
        modal.find('.modal-body').load(url, function() {
            if (size === 'mid-large') {
                modal.find('.modal-dialog').removeClass('modal-sm').addClass('modal-lg');
            } else if (size === 'small') {
                modal.find('.modal-dialog').removeClass('modal-lg').addClass('modal-sm');
            } else {
                modal.find('.modal-dialog').removeClass('modal-sm modal-lg');
            }
        });
        modal.modal('show');
    }
});
</script>
