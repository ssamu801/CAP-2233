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
</style>
</head>
<body>

<?php 
// Include configuration file 
include_once 'config.php'; 
 
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
?>

<!-- Status message -->
<?php if(!empty($statusMsg)){ ?>
    <div style='width:50%; margin-left: auto; ; margin-right: auto; padding-bottom: 20px; padding-top: 20px;' class="alert alert-<?php echo $status; ?>"><?php echo $statusMsg; ?></div>
<?php } ?>
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
                <input type="text" class="form-control" id="sessionTitle" name="title" value='Consultation - ' >
            </div>
            <div class="form-group">
                <label>Session Description</label>
                <input type="text" name="description" class="form-control" required></input>
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
            <label>Select Starting Date</label>
            <textarea id="selectedDate" name="selectedDate" class="form-control" readonly></textarea>
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



    // Function to open the modal
    $('#selectedDate').click(function(){
        var heading = "Update Availability"; // Set the modal title text here
        view_modal(heading, "./appointments/sessionsPicker.php", 'mid-large');
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

    // Function to close the modal when the close button is clicked
    $(".close").click(function() {
        $("#availabilityModal").modal('hide');
    });

    // Close the modal if the user clicks outside of it
    $(window).click(function(event) {
        if (event.target == document.getElementById("availabilityModal")) {
            $("#availabilityModal").modal('hide');
        }
    });

    // Add event listener to session title input
    $('#sessionTitle').on('input', function() {
        var startText = "Consultation - ";
        if (!this.value.startsWith(startText)) {
            this.value = startText + this.value.substring(startText.length);
        }
    });
});

    function validateForm() {
        var selectedDate = document.getElementById("selectedDate").value;
        if (selectedDate.trim() == "") {
            alert("Please select a schedule.");
            return false; // Prevent form submission
        }
        var sessionsNo = document.querySelector("input[name='sessionsNo']").value;
        if (sessionsNo <= 0 || isNaN(sessionsNo)) {
            alert("Please enter a positive number for the number of sessions.");
            return false; // Prevent form submission
        }
        return true; // Allow form submission
    }    

    $('.text-jqte').jqte();
    $('#addEventToDB').submit(function(e){
        e.preventDefault()

        var selectedDate = document.getElementById("selectedDate").value;
            if (selectedDate.trim() == "") {
                alert("Please select a schedule.");
                return false; // Prevent form submission
            }

        var selectedLocation = $("input[name='mode']:checked").val();
        if (!selectedLocation) {
            alert("Please select mode of session.");
            return false; // Prevent form submission
        }    
        
        var sessionsNo = document.querySelector("input[name='sessionsNo']").value;
        if (sessionsNo <= 0 || isNaN(sessionsNo)) {
            alert("Please enter a positive number for the number of sessions.");
            return false; // Prevent form submission
        }

        start_load()
        $.ajax({
            url:'ajax.php?action=save_appointment',
            method:'POST',
            data:$(this).serialize(),
            success:function(resp){
                if(resp == 1){
                    alert_toast("Request submitted. Waiting for approval.",'success')
                    setTimeout(function(){
                        location.reload()
                    },1000)
                }
            }
        })
    })
</script>

</body>
</html>
