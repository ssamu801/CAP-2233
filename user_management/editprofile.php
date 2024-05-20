<html>
<head>
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css">    
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
	<title>Edit Profile</title>
</head>
<style>
	.img-thumbnail{
		width: 200px;
 		height: 200px;
  		border-radius: 50%;
  		object-fit: cover;

	}
	.profile-label {
    position: relative;
    top: 10px; 
	}

	.btn-profile{
		background-color: #107A32; 
		color: white;
	}

	.btn-profile:hover{
		background-color: #107A32; 
		color: white;
	}
</style>
	<?php
	include("db_connect.php");

	$user_id = $_SESSION['login_id'];
			$sql = "
			SELECT name, id, username,email
			FROM   users 
			WHERE  id = $user_id";
			$records = mysqli_query($conn, $sql) or die(mysqli_error($conn));
			
			while($results = mysqli_fetch_array($records))
			{
				$NAME = $results['name'];
				$ID = $results['id'];
				$USERNAME = $results['username'];
				$EMAIL = $results['email'];
			}
			
	?>
	<form method='post' action='index.php?page=user_management/profile'>  
	<input type='hidden' name='id' value='<?php echo $ID?>'>
			<div class='row py-5 px-4'> 
				<div class='col-md-12 mx-auto'>
					<!-- Profile widget -->
					<div class='bg-white shadow rounded overflow-hidden' >
						<div class='px-5 pt-0 cover' > 
							<div class='media align-items-end profile-head' > 
								<div class='profile mr-3' >
									<img src='https://6.soompi.io/wp-content/uploads/image/20231016024204_kim-chaewon-1.jpeg?s=900x600&e=t' class='mt-5 mb-2 img-thumbnail'>
								</div> 
								<div class='media-body mb-5 text-white profile-label'> 
									<h4 class='mt-0 mb-0' style='color:black'><input type='text' name='name' value='<?php echo $NAME?>'></h4> 
									<p class='large' style='color:black'>ID: <?php echo $ID?></p> 
									<hr>
									<div class="button-group">
        								<button type='submit' class="btn mr-2 btn-profile">Save profile</button>
    								</div>
								</div> 
							</div>
						</div> 

						<div class='px-5 pb-3'> <h5 class='mb-3'>About</h5> 
							<div class='p-4 rounded shadow-sm bg-light'> 
							<p class='font-italic mb-1'>Username: <input type='text' name='username' value='<?php echo $USERNAME?>'></p>
							<p class='font-italic mb-1'>Email: <input type='text' name='email' value='<?php echo $EMAIL?>'></p>
							</div> 
						</div> 
					</div> 
				</div>
			</div>
		</form>
</body>
</html>