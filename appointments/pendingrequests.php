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
                                         <?php
                                            $time_from = $row['time_from'];
                                            $formatted_time = date("h:i A", strtotime($time_from));
                                            echo $formatted_time;
                                        ?>
				 	                    </td>
                                         <td class="text-center">
                                         <?php
                                            $time_from = $row['time_to'];
                                            $formatted_time = date("h:i A", strtotime($time_from));
                                            echo $formatted_time;
                                        ?>
				 	                    </td>
                                         <td class="text-center">
                                            <?php echo $row['location'] ?>
				 	                    </td>
                                        <td class="text-center">
                                        <button class="btn btn-success text-white" id="accept" data-id="<?php echo $row['id'] ?>">Accept</button>
                                        </td>
                                    
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

$('#accept').click(function(){
		uni_modal2("Accept Appointment Request","appointments/pending_modal.php?id="+$(this).attr('data-id'),'mid-large')
})
</script>

<?php
/* Changes as of 11:00PM - May 6, 2024
    Main changes: updated SQL query

    - Added line 18
    - Added line 30
    - Changed line 31
    - Added lines 32 - 39
    - Changed line 46
    - Changed line 49
    - Added lines 55 - 59
    - Added lines 62 - 66
    - Added lines 71 - 74

   End of Changes*/
?>