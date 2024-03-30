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
 					include '../db_connect.php';
 					$type = array("","Admin","Staff","Subscriber");
 					$users = $conn->query("SELECT * FROM users order by name asc");
 					$i = 1;
 					while($row= $users->fetch_assoc()):
				 ?>
				 <tr>
				 	<td class="text-center">
					 	<?php echo $row['id'] ?>
				 	</td>
				 	<td class="text-center">
				 		<?php echo ucwords($row['name']) ?>
				 	</td>

                     <td class="text-center">
				 		<?php echo ucwords($row['name']) ?>
				 	</td>
				 	
				 	<td class="text-center">
				 		<?php echo $row['username'] ?>
				 </tr>
				<?php endwhile; ?>
			</tbody>
</table>
			
<script>
$('table').dataTable();


</script>