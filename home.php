<?php include 'db_connect.php' ?>
<?php

if( $_SESSION['login_type'] == 1){
    echo '<script type="text/javascript">
    setTimeout(function() {
        window.location.href = "index.php?page=dashboard_admin";
    }, 0000); 
    </script>';
}
else if( $_SESSION['login_type'] == 2){
    echo '<script type="text/javascript">
    setTimeout(function() {
        window.location.href = "index.php?page=dashboard_secretary";
    }, 0000); 
    </script>';
}
else if( $_SESSION['login_type'] == 3){
    echo '<script type="text/javascript">
    setTimeout(function() {
        window.location.href = "index.php?page=dashboard_counselor";
    }, 0000); 
    </script>';
}
else if( $_SESSION['login_type'] == 4){
    echo '<script type="text/javascript">
    setTimeout(function() {
        window.location.href = "index.php?page=social_interaction/post_approval";
    }, 0000); 
    </script>';
}
else if( $_SESSION['login_type'] == 5){
    echo '<script type="text/javascript">
    setTimeout(function() {
        window.location.href = "index.php?page=information_resources/home";
    }, 0000); 
    </script>';
}

?>