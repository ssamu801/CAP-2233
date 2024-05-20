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
                        <b>Notifications</b>
                        <span class=""></span>
                    </div>
                    <div class="card-body">
                        <table class="table">

                            <?php
                   
                                include './db_connect.php';
                                $requests = $conn->query("SELECT * FROM event_notifications"); // fix yung condition to idnum or email
                                $total = mysqli_num_rows($requests);
                                if($total > 0):
                                    while($row= $requests->fetch_assoc()):
                            ?>
                                    <?php if($_SESSION['login_id'] == $row['id']): ?>
                                    <tr>
				 	                    <td class="text-center">
                                          <?php echo $row['description'] ?> by <?php echo $row['counselor_name'] ?> <br> 
                                          When:  <?php echo date('F j, Y',strtotime($row['event_date'])); ?> ,
                                                 <?php echo date("h:i A", strtotime($row['event_start'])); ?> - 
                                                 <?php echo date("h:i A", strtotime($row['event_end'])); ?><br>
                                          Where: <?php echo $row['location'] ?>
				 	                    </td>
                                         <td class="text-center">
				 		                    <?php echo $row['time'] ?>
				 	                    </td>
                                    </tr>
                                    <?php endif; ?>
                            <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan='6' style='text-align:center;'>There are currently no pending requests</td>
                                </tr>
                            <?php endif; ?>

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
