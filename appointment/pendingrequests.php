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


    <div style='width:50%; margin-left: 300px; padding-top: 250px; padding-bottom: 100px'>
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
         SELECT * FROM events WHERE status = 'Pending'";
         
        $records = mysqli_query($conn, $sql) or die(mysqli_error($conn));
        $total = mysqli_num_rows($records);

        if($total > 0){
            while ($results = mysqli_fetch_array($records)) {

                if($results['status'] == "Pending"){
                    echo"
                    <tbody>
                        <tr>
                            <form method='post' action='addevent.php'>  
                                <input type='hidden' id='userID' name='userID' value=$results[id]>
                                <td><input type='text' value='$results[user_email]' name='email' readonly></td>
                                <td><input type='text' value='$results[counselor_email]' name='email' readonly></td>
                                <td><input type='text' value='$results[title]' name='title' readonly></td>
                                <td><input type='text' value='$results[date]' name='date' readonly></td>
                                <td><input type='text' value='$results[time_from]' name='time_from' readonly></td>
                                <td><input type='text' value='$results[time_to]' name='time_to' readonly></td>
                                <td><input type='submit' name='Accept' value='Accept'/></td>
                                <td><input type='submit' name='Reject' value='Reject'/></td>
                            </form>
                        </tr>
                    </tbody>
                    ";
                    } 
            } 
        } else {
            echo"
            <tbody>
                <tr>
                <td colspan='5' style='text-align:center;'>There are currently no pending requests</td>
                </tr>
            </tbody>
            ";
        }
	
        ?>
        </table>
    </div>
    			
		
</body>
</html>
