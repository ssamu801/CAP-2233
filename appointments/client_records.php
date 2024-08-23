<?php  include('./db_connect.php'); ?>
<?php

if(  $_SESSION['login_type'] != 3){
	echo '<script type="text/javascript">
	setTimeout(function() {
		window.location.href = "index.php?page=home";
	}, 0000); 
	</script>';
}
$login_id = $_SESSION['login_id'];
?>
<style>
	.record_row:hover{
		cursor: pointer;
	}
</style>

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
						<b>Client Records</b>
						<span class=""></span>
                    </div>
                    <div class="card-body">
						<table class="table table-striped table-hover">
                            <thead>
				                <tr>
					                <th class="text-center">ID Number</th>
					                <th class="text-center">Name</th>
					                <th class="text-center">Email</th>
				                </tr>
			                </thead>
							<tbody>
				                <?php
 					                include './db_connect.php';
									$counselor_email = $_SESSION['login_email'];
 					                $type = array("","Admin","Staff","Subscriber");
 					                $users = $conn->query("SELECT u.id, u.name, u.email FROM users u JOIN events e ON u.email=e.user_email WHERE e.counselor_id = $login_id GROUP BY u.id ORDER BY u.name ASC");
 					                $i = 1;
 					                while($row= $users->fetch_assoc()):
				                ?>
				                <tr class="client_record record_row" data-id="<?php echo $row['id'] ?>">
				 	                <td class="text-center">
				 		                <?php echo $row['id'] ?>
				 	                </td>
				 	                <td class="text-center">
				 		                <?php echo ucwords($row['name']) ?>
				 	                </td>
				 	
				 	                <td class="text-center">
				 		                <?php echo $row['email'] ?>
				 	                </td>

				                </tr>
				            <?php endwhile; ?>
			            </tbody>
					</table>
					</div>    
                </div>         
            </div>     
        </div>   
    </div>
</div>
<script>

$('.client_record').click(function(){
    var dataId = $(this).attr('data-id');
    var clientName = $(this).find('td:eq(1)').text(); // Assuming the name is in the second column (index 1)
    view_modal("Client Record: " + clientName + " (ID: " + dataId + ")", "appointments/session_records.php?id=" + dataId, 'large');	
});
$('table').dataTable();


</script>
