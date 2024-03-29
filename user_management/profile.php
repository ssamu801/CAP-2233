<html>
<head>
<meta charset="UTF-8">
	<title>Profile</title>
</head>
     <?php
	
	include("./db_connect.php");
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // collect value of input field	
       		$NAME = $_POST['name'];
			$ID = $_POST['id'];
			$USERNAME = $_POST['username'];
			$EMAIL = $_POST['email'];
			$_SESSION['login_name'] = $_POST['name'];
			
              $sql = 
			  "UPDATE `users` SET `name`='$NAME',`id`='$ID',`username`='$USERNAME',`email`='$EMAIL' WHERE  id = $ID;";
              $records = mysqli_query($conn, $sql) or die(mysqli_error($conn));
      } 
	  $userID = $_SESSION['login_id'];

	  $sql = "
			SELECT name, id, username, email
			FROM   users 
			WHERE  id = $userID;";
			
			$records = mysqli_query($conn, $sql) or die(mysqli_error($conn));
			
			while($results = mysqli_fetch_array($records))
			{
			$NAME = $results['name'];
			$ID = $results['id'];
			$USERNAME = $results['username'];
			$EMAIL = $results['email'];
			// $IDNUM = $wow['id_number'];
			// $EMAIL = $wow['email'];
			// $PHONENUM = $wow['phone_number'];
			}
			
		?>
	  	<form method='post' action='index.php?page=user_management/editprofile'>  
			<div class='row py-5 px-4'> 
				<div class='col-md-5 mx-auto'>
					<!-- Profile widget -->
					<div class='bg-white shadow rounded overflow-hidden' >
						<div class='px-4 pt-0 pb-4 cover' > 
							<div class='media align-items-end profile-head' > 
								<div class='profile mr-3' >
									<img src='https://images.unsplash.com/photo-1522075469751-3a6694fb2f61?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=500&q=80' alt='...' width='130' class='rounded mb-2 img-thumbnail'>
									<button href='#' type='submit' class='btn btn-outline-dark btn-sm btn-block'>Edit profile</button>
								</div> 
								<div class='media-body mb-5 text-white'> 
									<h4 class='mt-0 mb-0' style='color:black'><?php echo $NAME?></h4> 
									<p class='large mb-4' style='color:black'>ID: <?php echo $userID?></p> 
								</div> 
							</div>
						</div> 

						<div class='px-4 py-3'> <h5 class='mb-0'>About</h5> 
							<div class='p-4 rounded shadow-sm bg-light'> 
							<p class='font-italic mb-1'>Username: <?php echo $USERNAME?></p>
							<p class='font-italic mb-1'>Email: <?php echo $EMAIL?></p>
							</div> 
						</div> 
					</div> 
				</div>
			</div>
		</form>
		
	
		
</body>
</html>