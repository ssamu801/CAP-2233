<?php session_start()?>
<?php
if(  $_SESSION['login_type'] != 3){
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
            <th class="text-center">Date of Availed Session</th>
            <th class="text-center">Time of Availed Session</th>
            <th class="text-center">Attending Counselor</th>
            <th class="text-center">Type</th>
            <th class="text-center">Location</th>
            <th class="text-center">Status</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $user_id = $_GET['id'];
        $clientName = $_GET['clientName'];
        $login_id = $_SESSION['login_id'];
        include '../db_connect.php';
        $users = $conn->query("SELECT e.date, e.time_from, e.time_to, e.counselor_name, e.status, e.title, e.location, e.id 
                               FROM users u 
                               JOIN events e ON u.email=e.user_email 
                               WHERE u.id= $user_id
                               AND e.counselor_id = $login_id
                               AND status = 'Scheduled' OR status = 'Completed'
                               ORDER BY e.date DESC");
        while($row = $users->fetch_assoc()):
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
            <td class="text-center"><?php echo $row['counselor_name']; ?></td>
            <td class="text-center"><?php echo $row['title']; ?></td>
            <td class="text-center"><?php echo $row['location']; ?></td>
            <td class="text-center"><?php echo $row['status']; ?></td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>
<br>
<!-- Button to redirect to Change Counselor page -->
<button class="btn btn-secondary float-right mr-2 change_counselor" data-id="<?php echo $user_id; ?>" data-id2="<?php echo $clientName; ?>">Change Counselor</button>

<!-- Button to trigger the modal -->
<button class="btn btn-primary float-right add_intake_schedule" data-id="<?php echo $user_id; ?>">Add Session Date</button>

<!-- Modal structure -->
<div class="modal fade" id="dateModal" tabindex="-1" role="dialog" aria-labelledby="dateModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
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

<script>
// Redirect to Change Counselor page
$(document).on('click', '.change_counselor', function() {
    var dataId = $(this).attr('data-id');
    var dataId2 = $(this).attr('data-id2');
    window.location.href = "index.php?page=appointments/change_counselor_form&user_id=" + dataId + "&clientName=" + dataId2 ;
});

$(document).ready(function() {
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

    // Reset dropdown to default option when page loads
    $('#assignCounselorCheckbox').trigger('change');

    // Additional code for other functionalities (assigning counselor, session mode, etc.) can be added here as needed

    // Handle checkbox change event
    $('#assignCounselorCheckbox').change(function() {
        if ($(this).is(':checked')) {
            $('.counselor-dropdown').show();
        } else {
            $('.counselor-dropdown').hide();
            $('#counselorDropdown').val(''); // Reset dropdown to default option
        }
    });

    // Handle counselor dropdown change event
    $('#counselorDropdown').change(function() {
        var selectedValue = $(this).val();
        if (selectedValue !== '') {
            $('#selectedDate').val('');
            // AJAX to update session with selected counselor ID
            $.ajax({
                type: 'POST',
                url: './appointments/updateSessionCID.php',
                data: { counselorID: selectedValue },
                success: function(response) {
                    console.log('Counselor ID session variable updated successfully.');
                },
                error: function(xhr, status, error) {
                    console.error('Error updating counselor ID session variable:', error);
                }
            });
        }
    });

    // Update session mode when a radio button is selected
    $('input[name="mode"]').change(function() {
        var selectedMode = $('input[name="mode"]:checked').val();
        $('#selectedDate').val('');
        // AJAX to update session with selected mode
        $.ajax({
            type: 'POST',
            url: './appointments/updateSessionMode.php',
            data: { mode: selectedMode },
            success: function(response) {
                console.log('Session mode updated successfully.');
            },
            error: function(xhr, status, error) {
                console.error('Error updating session mode:', error);
            }
        });
    });

    // Function to open the modal
    $('#selectedDate').click(function() {
        var isModeSelected = $('input[name="mode"]:checked').length > 0;
        if (!isModeSelected) {
            alert("Please select a mode of session before selecting a date.");
            return;
        }
        if ($('#assignCounselorCheckbox').is(':checked') && !$('#counselorDropdown').val()) {
            alert("Please select a counselor before selecting a date.");
            return;
        }
        view_modal("Update Availability", "./appointments/dateAndTimePicker.php", 'mid-large');
    });

    // Form submission
    $('#addEventToDB').submit(function(e) {
        e.preventDefault();
        if ($('#assignCounselorCheckbox').is(':checked') && !$('#counselorDropdown').val()) {
            alert("Please select a counselor before submitting the form.");
            return;
        }
        if ($('input[name="mode"]:checked').length === 0) {
            alert("Please select a mode of session.");
            return;
        }
        if ($('#selectedDate').val() === '') {
            alert("Please select a date.");
            return;
        }
        start_load();
        $.ajax({
            url: 'ajax.php?action=save_appointment',
            method: 'POST',
            data: $(this).serialize(),
            success: function(resp) {
                if (resp == -1) {
                    alert_toast("Request submitted.", 'success');
                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                } else {
                    alert_toast("Request submitted.", 'success');
                    setTimeout(function() {
                        window.location.href = 'index.php?page=appointments/add_loc_f2f&resp=' + encodeURIComponent(resp);
                    }, 1000);
                }
            }
        });
    });
});
</script>
