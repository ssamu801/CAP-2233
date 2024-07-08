<?php
session_start();

if (isset($_POST['mode'])) {
    $_SESSION['session_mode'] = $_POST['mode'];
    echo 'Session mode updated successfully';
} else {
    echo 'No mode provided';
}
?>