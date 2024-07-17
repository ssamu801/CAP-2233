<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Profile</title>
<style>
    .img-thumbnail {
        width: 200px;
        height: 200px;
        border-radius: 50%;
        object-fit: cover;
    }
    .profile-label {
        position: relative;
        top: 10px;
    }
    .btn-profile {
        background-color: #107A32;
        color: white;
    }
    .btn-profile:hover {
        background-color: #107A32;
        color: white;
    }
    .modal-content{
        background-color: transparent;
        border: none;
    }
    .modal-header{
        border: none;
    }
</style>
<?php
    include("./db_connect.php");
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $NAME = $_POST['name'];
        $ID = $_POST['id'];
        $USERNAME = $_POST['username'];
        $EMAIL = $_POST['email'];
        $_SESSION['login_name'] = $_POST['name'];
        
        $sql = "UPDATE `users` SET `name`='$NAME',`id`='$ID',`username`='$USERNAME',`email`='$EMAIL' WHERE  id = $ID;";
        $records = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    } 
    $userID = $_SESSION['login_id'];
    $sql = "SELECT name, id, username, email FROM users WHERE id = $userID;";
    $records = mysqli_query($conn, $sql) or die(mysqli_error($conn));
    while($results = mysqli_fetch_array($records)) {
        $NAME = $results['name'];
        $ID = $results['id'];
        $USERNAME = $results['username'];
        $EMAIL = $results['email'];
    }
?>
</head>
<body>
    <form method='post' action='index.php?page=user_management/editprofile'>  
        <div class='row py-5 px-4'> 
            <div class='col-md-12 mx-auto'>
                <!-- Profile widget -->
                <div class='bg-white shadow rounded overflow-hidden' >
                    <div class='px-5 pt-0 cover' > 
                        <div class='media align-items-end profile-head' > 
                            <div class='profile mr-3' >
                                <img src='https://kpopping.com/documents/e6/4/800/Red-Velvet-Irene-2024-Photo-Exhibition-1-Page-of-IRENE-documents-2(2).jpeg?v=5cfcf' class='mt-5 mb-2 img-thumbnail'>
                            </div> 
                            <div class='media-body mb-5 text-white profile-label'> 
                                <h4 class='mt-0 mb-0' style='color:black'><?php echo $NAME?></h4> 
                                <p class='large' style='color:black'>ID: <?php echo $userID?></p> 
                                <hr>
                                <div class="button-group">
                                    <button type='submit' class="btn mr-2 btn-profile">Edit profile</button>
                                    <button type='button' class="btn btn-profile view_notif">Update Availability</button>
                                </div>
                            </div> 
                        </div>
                    </div> 
                    <div class='px-5 pb-3'> 
                        <h5 class='mb-3'>About</h5> 
                        <div class='p-4 rounded shadow-sm bg-light'> 
                            <p class='font-italic mb-1'>Username: <?php echo $USERNAME?></p>
                            <p class='font-italic mb-1'>Email: <?php echo $EMAIL?></p>
                        </div> 
                    </div> 
                </div> 
            </div>
        </div>
    </form>

    <!-- Modal -->
   <div id="availabilityModal" class="modal fade" role="dialog">
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
            $('.view_notif').click(function(){
                var heading = "Update Availability"; // Set the modal title text here
                view_modal(heading, "./appointments/cal.php", 'mid-large');
            });

            function view_modal(heading, url, size) {
                // Get the modal element
                var modal = $('#availabilityModal');

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
        });
</script>
</body>
</html>