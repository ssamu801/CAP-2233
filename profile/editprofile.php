<html>
<head>
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css">    
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
	<title>Edit Profile</title>
</head>
<body style="background-color:#006937">
	<?php
	include("connect.php");
	  
			$sql = "
			SELECT name, id, username
			FROM   users 
			WHERE  id = 123;";
			$records = mysqli_query($conn, $sql) or die(mysqli_error($conn));
			
			while($results = mysqli_fetch_array($records))
			{
				$NAME = $results['name'];
				$ID = $results['id'];
				$USERNAME = $results['username'];
			}
			
	 
		   echo"
		   <form method='post' action='profile.php'>  
		   <input type='hidden' name='id' value='$ID'>
		   <div class='row py-5 px-4'> 
			   <div class='col-md-5 mx-auto'>
				   <!-- Profile widget -->
				   <div class='bg-white shadow rounded overflow-hidden' >
					   <div class='px-4 pt-0 pb-4 cover' > 
						   <div class='media align-items-end profile-head' > 
							   <div class='profile mr-3' >
								   <img src='https://images.unsplash.com/photo-1522075469751-3a6694fb2f61?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=500&q=80' alt='...' width='130' class='rounded mb-2 img-thumbnail'>
								   <button href='#' type='submit' class='btn btn-outline-dark btn-sm btn-block'>Save profile</button>
							   </div> 
							   <div class='media-body mb-5 text-white'> 
								   <h4 class='mt-0 mb-0' style='color:black'><input type='text' name='name' value='$NAME'></h4> 
								   <p class='large mb-4' style='color:black'>ID$ID</p> 
							   </div> 
						   </div>
					   </div> 

					   <div class='px-4 py-3'> <h5 class='mb-0'>About</h5> 
						   <div class='p-4 rounded shadow-sm bg-light'> 
						   <p class='font-italic mb-1'>Email: <input type='text' name='username' value='$USERNAME'></p>
						   <p class='font-italic mb-1'>Course: </p>
						   <p class='font-italic mb-0'>Age:</p>
						   </div> 
					   </div> 
				   </div> 
			   </div>
		   </div>
	   </form>
		 "
	?>
</body>
</html>

