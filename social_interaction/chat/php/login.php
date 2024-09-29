<?php 
    session_start();
    include_once "config.php";
    $id = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    if(!empty($id) && !empty($password)){
        $sql = mysqli_query($conn, "SELECT * FROM users WHERE id = '{$id}'");
        if(mysqli_num_rows($sql) > 0){
            $row = mysqli_fetch_assoc($sql);
            $user_pass = md5($password);
            $enc_pass = $row['password'];
            if($user_pass === $enc_pass){
                $status = "Active now";
                $sql2 = mysqli_query($conn, "UPDATE users SET status = '{$status}' WHERE id = {$row['id']}");
                if($sql2){
                    $_SESSION['unique_id'] = $row['id'];
                    echo "success";
                }else{
                    echo "Something went wrong. Please try again!";
                }
            }else{
                echo "Email or Password is Incorrect!";
            }
        }else{
            echo "$id - This email not Exist!";
        }
    }else{
        echo "All input fields are required!";
    }
?>