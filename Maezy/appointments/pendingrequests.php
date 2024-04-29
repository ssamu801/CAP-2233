<div class="container-fluid">
    <div class="row mb-4 mt-4">
        <div class="col-md-12">
        </div>
    </div>
    <div class="col-lg-12">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <b>Pending Requests</b>
                        <span class=""></span>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="text-center">Name</th>
                                    <th class="text-center">Email</th>
                                    <th class="text-center">Date</th>
                                    <th class="text-center">Start Time</th>
                                    <th class="text-center">End Time</th>
                                    <th class="text-center">Location</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                   
                                $login_id = $_SESSION['login_id'];
                                include './db_connect.php';
                                $requests = $conn->query("SELECT e.id, e.user_email, e.user_name, e.date, e.location, e.time_from, e.time_to
                                                            FROM events e
                                                            JOIN availability a ON e.date = a.date
                                                            AND e.time_from = a.time_from
                                                            AND e.time_to = a.time_to
                                                            WHERE e.status = 'Pending'
                                                            AND a.status = 'Available'
                                                            AND a.counselorID = $login_id;");
                                $total = mysqli_num_rows($requests);
                                if($total > 0):
                                    while($row= $requests->fetch_assoc()):
                            ?>
                                    <tr class="client_record record_row" data-id="<?php echo $row['id'] ?>">
				 	                    <td class="text-center">
				 		                    <?php echo $row['user_name'] ?>
				 	                    </td>
				 	                    <td class="text-center">
				 		                    <?php echo$row['user_email'] ?>
				 	                    </td>
				 	                    <td class="text-center">
				 		                    <?php echo $row['date'] ?>
				 	                    </td>
				 	                    <td class="text-center">
                                            <?php echo $row['time_from'] ?>
				 	                    </td>
                                         <td class="text-center">
                                            <?php echo $row['time_to'] ?>
				 	                    </td>
                                         <td class="text-center">
                                            <?php echo $row['location'] ?>
				 	                    </td>
                                        
                                        
                                         
                                        <form method='post' action='index.php?page=appointments/addevent'> 
                                            <input type='hidden' id='counselor_email' name='counselor_email' value='<?php echo $_SESSION['login_email']; ?>'>
                                            <input type='hidden' id='counselor_name' name='counselor_name' value='<?php echo $_SESSION['login_name']; ?>'>
                                            <input type='hidden' id='userID' name='userID' value='<?php echo $row['id']; ?>'>
                                            <input type='hidden' value='<?php echo $row['user_email']; ?>' name='email'>
                                            <input type='hidden' value='<?php echo $row['title']; ?>' name='title'>
                                            <input type='hidden' value='<?php echo $row['date']; ?>' name='date'>
                                            <input type='hidden' value='<?php echo $row['time_from']; ?>' name='time_from'>
                                            <input type='hidden' value='<?php echo $row['time_to']; ?>' name='time_to'>
                                            <td class="text-center"><input class="btn btn-success text-white" type='submit' name='Accept' value='Accept'/> <input class="btn btn-danger text-white" type='submit' name='Reject' value='Reject'/></td>
                                        </form>
                                    </tr>
                            <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan='6' style='text-align:center;'>There are currently no pending requests</td>
                                </tr>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>    
                </div>         
            </div>     
        </div>   
    </div>
</div>

<script>

$('table').dataTable();


</script>


