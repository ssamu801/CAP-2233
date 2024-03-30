<?php  include('./db_connect.php'); ?>

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
					                <th class="text-center">Username</th>
					                <th class="text-center">Type</th>
				                </tr>
			                </thead>
							<tbody>
				                <?php
 					                include './db_connect.php';
 					                $type = array("","Admin","Staff","Subscriber");
 					                $users = $conn->query("SELECT * FROM users WHERE type=3 order by name asc");
 					                $i = 1;
 					                while($row= $users->fetch_assoc()):
				                ?>
				                <tr class="client_record record_row" data-id="<?php echo $row['id'] ?>">
				 	                <td class="text-center">
				 		                <?php echo $row['id'] ?>
				 	                </td>
				 	                <td>
				 		                <?php echo ucwords($row['name']) ?>
				 	                </td>
				 	
				 	                <td>
				 		                <?php echo $row['username'] ?>
				 	                </td>
				 	                <td>
				 		                <?php echo $type[$row['type']] ?>
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
