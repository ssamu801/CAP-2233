<table class="table table-striped col-md-12">
			<thead>
				<tr>
					<th class="text-center">Date of Availed Session</th>
					<th class="text-center">Time of Availed Session</th>
                    <th class="text-center">Attending Counselor</th>
					<th class="text-center">Status</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$user_id = $_GET['id'];
 					include '../db_connect.php';
 					$type = array("","Admin","Staff","Subscriber");
 					$users = $conn->query("SELECT e.date, e.time_from, e.time_to, e.counselor_name, e.status 
										   FROM users u 
										   JOIN events e ON u.email=e.user_email 
										   WHERE u.id= $user_id
										   ORDER BY e.date DESC");
 					$i = 1;
 					while($row= $users->fetch_assoc()):
				 ?>
				 <tr>
				 	<td class="text-center">
					 	<?php echo $row['date'] ?>
				 	</td>
				 	<td class="text-center">
					 <?php

						$time_from = date("h:i A", strtotime($row['time_from']));
						$time_to = date("h:i A", strtotime($row['time_to']));

						echo $time_from . " - " . $time_to;
					?>
				 	</td>

                     <td class="text-center">
				 		<?php echo $row['counselor_name'] ?>
				 	</td>
				 	
				 	<td class="text-center">
				 		<?php echo $row['status'] ?>
				 </tr>
				<?php endwhile; ?>
			</tbody>
</table>
			
<script>
$('table').dataTable();


</script>