<?php
  $hostname = "localhost";
  $username = "root";
  $password = "";
  $dbname = "chatapp";

  $conn= new mysqli('cap-2233-cap2233.a.aivencloud.com:10292',
                  'avnadmin',
                  'AVNS_ZQTc4dKbpYkzHCia2nZ',
                  'cap2233')or die("Could not connect to mysql".mysqli_error($con));
  if(!$conn){
    echo "Database connection error".mysqli_connect_error();
  }
?>
