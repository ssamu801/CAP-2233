<!DOCTYPE html>
<html lang="en">

<?php 
session_start();
include('./db_connect.php');
?>
<?php include('./header.php'); ?>

<?php 
if(isset($_SESSION['login_id']))
header("location:index.php?page=home");

?>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">    
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="css/login_style.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <title>Login and Register | WASP: A Digital University-Based Mental Health and Well-Being Support Platform</title>
</head>
<body>

    <div class="container">
        <div class="logo"> <!--sample logo for now-->
            <img src="images/DLSU_logo.png" alt="Logo" class="img-fluid">
        </div>
        <div class="forms">
            <!-- Login Form -->
            <div class="form login">
                <span class="title">Hello, Lasallian!</span>
                <form id="login-form">
                    <div class="input-field">
                        <input type="text" name="idNum" placeholder=" Enter your ID Number" required/>
                        <i class="uil uil-dialpad-alt icon"></i>
                    </div>
                    <div class="input-field">
                        <input type="password" class="password" placeholder=" Enter Password" name="password_login" required/>
                        <i class="uil uil-lock icon"></i>
                        <i class="uil uil-eye-slash eye"></i>
                    </div>
                    <div class="input-field button">
                        <input type="submit" name="loginbtn" value="Login"/>
                    </div>
                </form>
                
                <div class="register">
                    <span class="text">No account yet?
                        <a href="#" class="text register-link" id="registerLink">Register Now!</a>
                    </span>
                </div>
                <div class="forgotPass">
                    <a href="#" class="text password-link" id="forgotPassword">Forgot Password?</a>
                </div>
            </div>
            
            <!-- Registration Form -->
            <div class="form registration hidden-form">
                <span class="title">Sign Up</span>
                <form action="register.php" method="post">
                    <div class="input-field">
                        <input type="text" name="name" placeholder=" Enter a Username" required />
                        <i class="uil uil-user-circle icon"></i>
                    </div>
                    <div class="input-field">
                        <input type="text" name="fullName" placeholder=" Enter Full Name" required/>
                        <i class="uil uil-dialpad-alt icon"></i>
                    </div>
                    <div class="input-field">
                        <input type="text" name="idNum" placeholder=" Enter your ID Number" minlength="8" maxlength="8" required />
                        <i class="uil uil-dialpad-alt icon"></i>
                    </div>
                    <div class="input-field">
                        <input type="text" name="email" placeholder=" Enter Email" required />
                        <i class="uil uil-envelope icon"></i>
                    </div>
                    <div class="input-field">
                        <input type="password" class="password" placeholder="Create Password" name="firstPassword" required />
                        <i class="uil uil-lock icon"></i>
                    </div>
                    <div class="input-field">
                        <input type="password" class="password" placeholder="Confirm Password" name="password" required />
                        <i class="uil uil-lock icon"></i>
                        <i class="uil uil-eye-slash eye"></i>
                    </div>
                    <div class="input-field button">
                        <input type="submit" name="registerbtn" value="Sign in"/>
                    </div>
                </form>

                <div class="login-signin">
                    <span class="text">I have an account!
                        <a href="login.php" class="text login-link">Login Now!</a>
                    </span>
                </div>

            </div>
        </div>
    </div>

    <!-- JS to hide and show registration form without creating another file for registration-->
    <script src="js/forms.js"></script>
    <script src="js/fordeco.js"></script>

    <script>
	$('#login-form').submit(function(e){
		e.preventDefault()
		$('#login-form button[type="button"]').attr('disabled',true).html('Logging in...');
		if($(this).find('.alert-danger').length > 0 )
			$(this).find('.alert-danger').remove();
		$.ajax({
			url:'ajax.php?action=login',
			method:'POST',
			data:$(this).serialize(),
			error:err=>{
				console.log(err)
		$('#login-form button[type="button"]').removeAttr('disabled').html('Login');

			},
			success:function(resp){
				if(resp == 1){
					location.href ='index.php?page=home';
				}else{
					$('#login-form').prepend('<div class="alert alert-danger">Username or password is incorrect.</div>')
					$('#login-form button[type="button"]').removeAttr('disabled').html('Login');
				}
			}
		})
	})
</script>	
</body>
</html>
