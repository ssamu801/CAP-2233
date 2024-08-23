<?php
session_start();

if (isset($_POST['mode'])) {
    $_SESSION['session_mode'] = $_POST['mode'];
    
} else {
    echo 'No mode provided';
}
?>