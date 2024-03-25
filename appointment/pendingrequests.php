<html>
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css">    
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
	<title>Requests</title>
</head>
<body style="background-color:#006937">


    <div style='width:50%; margin-left: auto; margin-right: auto; padding-top: 250px; padding-bottom: 100px'>
        <table class='table table-hover table-striped table-dark'>
            <thead>
                <tr>
                <th scope='col'>Email</th>
                <th scope='col'>Title</th>
                <th scope='col'>Date</th>
                <th scope='col'>Start Time</th>
                <th scope='col'>End Time</th>
                </tr>
            </thead>

     <?php
     	include("connect.php");

         $sql = "
         SELECT * FROM events";
         
        $records = mysqli_query($conn, $sql) or die(mysqli_error($conn));
 
        while ($results = mysqli_fetch_array($records)) {
            if($results['status'] == "pending"){
                echo"
                <tbody>
                    <tr>
                    <form method='get' action='addevent.php'>  
                         <input type='hidden' id='custId' name='custId' value=$results[id]>
                        <td>$results[email]</td>
                        <td>$results[title]</td>
                        <td>$results[date]</td>
                        <td>$results[time_from]</td>
                        <td>$results[time_to]</td>
                        <td><input type='submit' name='Accept' value='Accept' /></td>
                        <td><input type='submit' name='Reject' value='Reject' /></td>
                    </tr>
                </tbody>
                ";
                }
        } 	
        ?>
        </table>
    </div>
    			
		
</body>
</html>