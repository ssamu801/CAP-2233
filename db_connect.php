<?php 
require_once 'appointments/config.php';
$conn= new mysqli('cap-2233-cap2233.a.aivencloud.com:10292',
                  'avnadmin',
                  'AVNS_ZQTc4dKbpYkzHCia2nZ',
                  'cap2233')or die("Could not connect to mysql".mysqli_error($con));

// mysqli_select_db($conn, 'sample_forum')

?>