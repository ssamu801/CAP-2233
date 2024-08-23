<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Requests</title>
<style>
    .modal-content{
        background-color: transparent;
        border: none;
    }
    .modal-header{
        border: none;
    }
    .disabled-date{
        background-color:#f1f1f1;
        color:#b1b1b1;
    }
    .counselor-dropdown {
        display: none;
    }
</style>
</head>
<body>

<?php 
// Include configuration file 
include_once 'config.php'; 
include './db_connect.php';

$user_id = $_SESSION['login_id'];
$status = '';
$result = $conn->query("SELECT status FROM events WHERE student_id = $user_id ORDER BY created DESC LIMIT 1");
if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $status = $row['status'];     
} 

if($status == 'Scheduled'){
    echo '<script type="text/javascript">
    alert("You currently have a scheduled appointment. You cannot proceed with requesting for another appointment.");
	setTimeout(function() {
		window.location.href = "index.php?page=home";
	}, 0000); 
	</script>';
}
 
$postData = ''; 
if(!empty($_SESSION['postData'])){ 
    $postData = $_SESSION['postData']; 
    unset($_SESSION['postData']); 
} 
 
$status = $statusMsg = ''; 
if(!empty($_SESSION['status_response'])){ 
    $status_response = $_SESSION['status_response']; 
    $status = $status_response['status']; 
    $statusMsg = $status_response['status_msg']; 
}

if(isset($_SESSION['counselorID'])){
    unset($_SESSION['counselorID']);
}

if(isset($_SESSION['counselorName'])){
    unset($_SESSION['counselorName']);
}

if(isset($_SESSION['counselorEmail'])){
    unset($_SESSION['counselorEmail']);
}

if(isset($_GET['counselor_id'])){
    $_SESSION['counselorID'] = $_GET['counselor_id'];

    $id = $_SESSION['counselorID'];
    $result = $conn->query("SELECT name, email FROM users WHERE id = $id");

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['counselorName'] = $row['name']; // Store counselor name in session
        $_SESSION['counselorEmail'] = $row['email']; // Store counselor email in session
    } 
}

$counselors = $conn->query("SELECT id, name FROM users WHERE type=3");
?>

<div class="row mb-4 mt-4">
    <div class="col-md-12">
        
    </div>
</div>
<div class="col-md-12" style='width:50%; margin-left: auto; ; margin-right: auto; padding-bottom: 20px; padding-top: 20px; background-color:#FFFFFF' >
  <!--  <form method="post"  action="index.php?page=appointments/addeventtodb" class="form" onsubmit="return validateForm()"> -->
        <form action="" id="addEventToDB" class="form">
        <?php
            include './db_connect.php';
            $id = $_SESSION['login_id'];
            $requests = $conn->query("SELECT name, email FROM users where id = '$id';");
            $total = mysqli_num_rows($requests);
            if($total > 0):
                while($row= $requests->fetch_assoc()):
        ?>
            <input type="hidden" name="user_name" value='<?php echo $row["name"]; ?>'>
            <input type="hidden" name="user_email" value='<?php echo $row["email"];?>'>
            <input type="hidden" name="student_id" value='<?php echo $id;?>'>
            <div class="form-group">
                <label>Session Title</label>
                <input type="text" class="form-control" name="title" value='Consultation - <?php echo $row["name"]; ?>' readonly >
            </div>
            <div class="form-group">
                <label>Session Description</label>
                <input type="text" name="description" class="form-control" value='Consultation with student named <?php echo $row["name"]; ?>, ID<?php echo $id; ?>' readonly ></input>
            </div>
        <?php endwhile; ?>
        <?php endif; ?>
        <div class="form-group">
            <label>Mode of Session</label><br>
            <!-- <input type="text" name="location" class="form-control" required> -->
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="mode" id="inlineRadio1" value="Online">
                <label class="form-check-label" for="inlineRadio1">Online</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="mode" id="inlineRadio2" value="Face-To-Face">
                <label class="form-check-label" for="inlineRadio2">Face-To-Face</label>
            </div>
        </div>
        <div class="form-group">
            <label>Have a Preferred Counselor?</label>
            <input type="checkbox" name="assignCounselorCheckbox" id="assignCounselorCheckbox" value="Yes" style="width: 15px; height: 15px;"
            <?php if (isset($_GET['counselor_id'])) { echo "checked"?> >  <?php } ?>
        </div>
        <div class="form-group counselor-dropdown">
            <label>Select Counselor</label>
            <select id="counselorDropdown" name="counselor" class="form-control">
                <option value="">Select Counselor</option> <!-- Added default option -->
                <?php if (isset($_GET['counselor_id'])) { ?>
                    <option selected="selected" value="<?php echo $_GET['counselor_id']; ?>"><?php echo $_GET['counselor_name']; ?></option>
                <?php } else { ?>
                    <?php if ($counselors->num_rows > 0) { ?>
                        <?php while($row = $counselors->fetch_assoc()) { ?>
                            <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                        <?php } ?>
                    <?php } else { ?>
                        <option value="">No counselors available</option>
                    <?php } ?>
                <?php } ?>

            
            </select>
        </div>
        <div class="form-group">
            <label>Select Date</label>
            <input type="text" id="selectedDate" name="selectedDate" class="form-control" readonly>
        </div>
        <div class="form-group">
            <label>Notes for counselor (Optional)</label>
            <input type="text" name="notes" class="form-control"></input>
        </div>
        <div class="form-group">
            <label>Require urgent assistance: </label>
            <input type="checkbox" id="Urgent" name="urgency" value="Urgent" style="width: 15px; height:15px;">
        </div>
        <div class="form-group">
            <input type="submit" class="form-control navbar-color" name="submit" value="Submit Request" style="background-color: #107a32; color:white;"/>
        </div>
    </form>
</div>

<!-- Modal -->
<div id="dateModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-body">
                <!-- Modal body content will be loaded dynamically -->
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {

var counselorSelected = false;

// Check if counselor_id is set in the URL and set counselorSelected to true
if (window.location.search.includes('counselor_id')) {
    counselorSelected = true;
}

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
            var response = JSON.parse(resp);

            if (response.id == -1) {
                alert_toast("Request submitted.", 'success');
                setTimeout(function() {
                    window.location.href = './index.php?page=home'
                }, 1000);
            } else {
                alert_toast("Request submitted.", 'success');
                setTimeout(function() {
                    console.log(response.id);
                    window.location.href = 'index.php?page=appointments/add_loc_f2f&resp=' + encodeURIComponent(response.id);
                }, 1000);
            }
        }
    });
});

// Reset dropdown to default option when page loads
$('#assignCounselorCheckbox').trigger('change');

});

</script>

</body>
</html>


<?php 
    /* 
        18-20 css
        83
        87
        104-120 selection of counselor
        153-213
        215-227
        254-259
        260-297    
    */
?>