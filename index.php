<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">    
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="style.css">
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
                <form action="login.php" method="post">
                    <div class="input-field">
                        <input type="text" name="idNum" placeholder="Enter your ID Number" required/>
                        <i class="uil uil-dialpad-alt icon"></i>
                    </div>
                    <div class="input-field">
                        <input type="password" class="password" placeholder="Enter Password" name="password_login" required/>
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
                        <input type="text" name="name" placeholder="Enter a Username" required />
                        <i class="uil uil-user-circle icon"></i>
                    </div>
                    <div class="input-field">
                        <input type="text" name="idNum" placeholder="Enter your ID Number" required />
                        <i class="uil uil-dialpad-alt icon"></i>
                    </div>
                    <div class="input-field">
                        <input type="text" name="email" placeholder="Enter Email" required />
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
                        <a href="index.php" class="text login-link">Login Now!</a>
                    </span>
                </div>

            </div>
        </div>
    </div>

    <!-- JS to hide and show registration form without creating another file for registration-->
    <script src="forms.js"></script>
    <script src="fordeco.js"></script>
</body>
</html>
