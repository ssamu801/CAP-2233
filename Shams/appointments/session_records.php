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
 					include '../db_connect.php';
 					$type = array("","Admin","Staff","Subscriber");
 					$users = $conn->query("SELECT e.date, e.time_from, e.time_to, e.counselor_name, e.status, e.title, e.location, u.id 
										   FROM users u 
										   JOIN events e ON u.email=e.user_email 
										   WHERE u.id= $user_id
										   ORDER BY e.date DESC");
 					$i = 1;
 					while($row= $users->fetch_assoc()):
				 ?>
				 <tr>
				 	<td class="text-center">
					 	<?php echo $row['date'] ?>
				 	</td>
				 	<td class="text-center">
					 <?php

						$time_from = date("h:i A", strtotime($row['time_from']));
						$time_to = date("h:i A", strtotime($row['time_to']));

						echo $time_from . " - " . $time_to;
					?>
				 	</td>

                    <td class="text-center">
				 		<?php echo $row['counselor_name'] ?>
				 	</td>

					 <td class="text-center">
					 	<?php echo $row['counselor_name'] ?>
				 	</td>
					<td class="text-center">
						<?php echo $row['location'] ?>
					</td>
				 	
				 	<td class="text-center">
				 		<?php echo $row['status'] ?>
				 </tr>
				<?php endwhile; ?>
			</tbody>
</table>
<br>
<!-- Button to trigger the modal -->
<button class="btn btn-primary float-right add_intake_schedule" data-id="<?php echo $_GET['id']; ?>">Add Session Date</button>

<script>

$('.add_intake_schedule').click(function(){
    var dataId = $(this).attr('data-id');
    var clientName = $(this).find('td:eq(1)').text(); // Assuming the name is in the second column (index 1)
	view_modal("Add Appointment Schedule ", "appointments/add_intake_schedule_eventmaker.php?id="+dataId, 'large');	
});

$('table').dataTable();


$(document).ready(function() {

var counselorSelected = false;

// Function to handle checkbox change
$('#assignCounselorCheckbox').change(function() {
    if ($(this).is(':checked')) {
        $('.counselor-dropdown').show();
    } else {
        $('.counselor-dropdown').hide();
        $('#counselorDropdown').val(''); // Reset dropdown to default option
        counselorSelected = false; // Reset counselor selection status
        // Clear the selected date when hiding counselor dropdown
        $('#selectedDate').val('');

        // Unset counselorID session variable via AJAX
        $.ajax({
            type: 'POST',
            url: './appointments/updateSessionCID.php',
            data: { action: 'unsetCounselorID' }, // Specify action to unset counselorID
            success: function(response) {
                console.log('Counselor ID session variable unset successfully.');
            },
            error: function(xhr, status, error) {
                console.error('Error unsetting counselor ID session variable:', error);
            }
        });
    }
});

// Function to handle counselor dropdown change
$('#counselorDropdown').change(function() {
    var selectedValue = $(this).val(); // Get selected counselor ID
    counselorSelected = (selectedValue !== ''); // Update counselor selection status

    // Clear the selected date field when a new counselor is selected
    $('#selectedDate').val(''); // Clear selected date

    // AJAX to update session with selected counselor ID
    $.ajax({
        type: 'POST',
        url: './appointments/updateSessionCID.php',
        data: { counselorID: selectedValue }, // Pass selected counselor ID
        success: function(response) {
            console.log('Counselor ID session variable updated successfully.');
        },
        error: function(xhr, status, error) {
            console.error('Error updating counselor ID session variable:', error);
        }
    });
});


 // Update session mode when a radio button is selected
 $('input[name="mode"]').change(function() {
    var selectedMode = $('input[name="mode"]:checked').val(); // Get selected value
    // Clear the selected date if the mode is changed
    $('#selectedDate').val('');

    // Update session with selected mode
    $.ajax({
        type: 'POST',
        url: './appointments/updateSessionMode.php', // PHP script to handle session update
        data: { mode: selectedMode }, // Data to send to server-side script
        success: function(response) {
            console.log('Session mode updated successfully.'); // Log success message
        },
        error: function(xhr, status, error) {
            console.error('Error updating session mode:', error); // Log error message
        }
    });
});

 // Function to open the modal
 $('#selectedDate').click(function() {
    var isModeSelected = $('input[name="mode"]:checked').length > 0; // Check if a mode is selected

    if (!isModeSelected) {
        alert("Please select a mode of session before selecting a date.");
        return;
    }

    if ($('#assignCounselorCheckbox').is(':checked') && !counselorSelected) {
        alert("Please select a counselor before selecting a date.");
        return;
    }

    var heading = "Update Availability"; // Set the modal title text here
    view_modal(heading, "./appointments/dateAndTimePicker.php", 'mid-large');
});

function view_modal(heading, url, size) {
    // Get the modal element
    var modal = $('#dateModal');

    // Set the modal title
    modal.find('.modal-title').text(heading);

    // Load the content of cal.php into the modal body
    modal.find('.modal-body').load(url, function() {
        // Adjust the modal size based on the 'size' parameter
        if (size === 'mid-large') {
            modal.find('.modal-dialog').removeClass('modal-sm').addClass('modal-lg');
        } else if (size === 'small') {
            modal.find('.modal-dialog').removeClass('modal-lg').addClass('modal-sm');
        } else {
            modal.find('.modal-dialog').removeClass('modal-sm modal-lg');
        }
    });

    // Show the modal
    modal.modal('show');
}
// Form submission
$('#addEventToDB').submit(function(e) {
    e.preventDefault();

     // Check if the checkbox is checked but no counselor is selected
     if ($('#assignCounselorCheckbox').is(':checked') && !counselorSelected) {
        alert("Please select a counselor before submitting the form.");
        return;
    }
    
    // Check if a mode of session is selected
    var isModeSelected = $('input[name="mode"]:checked').length > 0;
    if (!isModeSelected) {
        alert("Please select a mode of session.");
        return;
    }

    // Check if a date is selected
    if ($('#selectedDate').val() === '') {
        alert("Please select a date.");
        return;
    }

    // Proceed with form submission via AJAX
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
            }
            else{
                alert_toast("Request submitted.", 'success');
                setTimeout(function() {
                    window.location.href = 'index.php?page=appointments/add_loc_f2f&resp=' + encodeURIComponent(resp);
                }, 1000);
            }
            
        }
    });
});

// Reset dropdown to default option when page loads
$('#assignCounselorCheckbox').trigger('change');

});

</script>