<?php include './db_connect.php' ?>

<div class="container-fluid">
<style>
	input[type=checkbox]
{
  /* Double-sized Checkboxes */
  -ms-transform: scale(1.5); /* IE */
  -moz-transform: scale(1.5); /* FF */
  -webkit-transform: scale(1.5); /* Safari and Chrome */
  -o-transform: scale(1.5); /* Opera */
  transform: scale(1.5);
  padding: 10px;
}
.list-group-item +  .list-group-item {
    border-top-width: 1px !important;
}
</style>

	<div class="col-lg-12">
		<div class="row mb-4 mt-4">
			<div class="col-md-12">
				
			</div>
		</div>
		<div class="row">
			<!-- FORM Panel -->

			<!-- Table Panel -->
			<div class="col-md-12">
				
				<div class="card">
					<div class="card-header">
						<b>Notifications</b>
					</div>
					<div class="card-body">
						<ul class="w-100 list-group" id="topic-list">
							<?php

                            $id =  $_SESSION['login_id'];
							$notifs = $conn->query("SELECT * FROM notifications WHERE posterID=$id ORDER BY time DESC");
							while($row= $notifs->fetch_assoc()):
							?>
							<li class="list-group-item mb-4">
								<div>
								<?php if($row['type'] == 1): ?>
									<?php 
										$heading = "";
										$notif_id = $row['id'];
										$sql = "SELECT t.title FROM notifications n JOIN topics t ON n.topic_id=t.id WHERE n.id=$notif_id LIMIT 1;";
										$result = $conn->query($sql);
										if ($result && $result->num_rows > 0) {
											$row_title = $result->fetch_assoc();
											$heading = "[DISCUSSION FORUM] Your post '" . $row_title['title'] . "' has been approved";
										} 
									?>
									<a href="#" class="filter-text view_notif" data-id="<?php echo $row['id'] . ' ' . $row['type']; ?>"
   										data-heading="<?php echo htmlspecialchars($heading); ?>"
   										style="color: #444444; font-weight: bold;"><?php echo $heading; ?>
									</a>
								<?php elseif($row['type'] == 2): ?>	
									<?php 
										$heading = "";
										$notif_id = $row['id'];
										$sql = "SELECT t.title FROM notifications n JOIN topics t ON n.topic_id=t.id WHERE n.id=$notif_id LIMIT 1;";
										$result = $conn->query($sql);
										if ($result && $result->num_rows > 0) {
											$row_title = $result->fetch_assoc();
											$heading = "[DISCUSSION FORUM] Your post '" . $row_title['title'] . "' has been rejected";
										} 
									?>
									<a href="#" class="filter-text view_notif" data-id="<?php echo $row['id'] . ' ' . $row['type']; ?>"
   										data-heading="<?php echo htmlspecialchars($heading); ?>"
   										style="color: #444444; font-weight: bold;"><?php echo $heading; ?>
									</a>
								<?php elseif($row['type'] == 3): ?>	
									<?php 
										$heading = "";
										$notif_id = $row['id'];
										$sql = "SELECT t.title, c.comment FROM notifications n JOIN comments c ON n.comment_id=c.id JOIN topics t ON c.topic_id=t.id WHERE n.id=$notif_id LIMIT 1;";
										$result = $conn->query($sql);
										if ($result && $result->num_rows > 0) {
											$row_title = $result->fetch_assoc();
											$heading = "[DISCUSSION FORUM] Comment '" . $row_title['comment'] . "' is accepted on Forum on post '" . $row_title['title'] . "'";
										} 
									?>
									<a href="#" class="filter-text view_notif" data-id="<?php echo $row['id'] . ' ' . $row['type']; ?>"
   										data-heading="<?php echo htmlspecialchars($heading); ?>"
   										style="color: #444444; font-weight: bold;"><?php echo $heading; ?>
									</a>
								<?php elseif($row['type'] == 4): ?>	
									<?php 
										$heading = "";
										$notif_id = $row['id'];
										$sql = "SELECT t.title, c.comment FROM notifications n JOIN comments c ON n.comment_id=c.id JOIN topics t ON c.topic_id=t.id WHERE n.id=$notif_id LIMIT 1;";
										$result = $conn->query($sql);
										if ($result && $result->num_rows > 0) {
											$row_title = $result->fetch_assoc();
											$heading = "[DISCUSSION FORUM] Comment '" . $row_title['comment'] . "' is not accepted on Forum on post '" . $row_title['title'] . "'";
										} 
									?>
									<a href="#" class="filter-text view_notif" data-id="<?php echo $row['id'] . ' ' . $row['type']; ?>"
   										data-heading="<?php echo htmlspecialchars($heading); ?>"
   										style="color: #444444; font-weight: bold;"><?php echo $heading; ?>
									</a>	
								<?php elseif($row['type'] == 5): ?>	
									<?php 
										$heading = "";
										$notif_id = $row['id'];
										$sql = "SELECT t.title, c.comment, u.name FROM notifications n JOIN comments c ON n.comment_id=c.id JOIN topics t ON n.topic_id=t.id JOIN users u ON u.id=c.user_id  WHERE n.id=$notif_id LIMIT 1;";
										$result = $conn->query($sql);
										if ($result && $result->num_rows > 0) {
											$row_title = $result->fetch_assoc();
											$heading = "[DISCUSSION FORUM] ".$row_title['name']. " commented on your post Forum '" . $row_title['title'] . "'";
										} 
									?>
									<a href="#" class="filter-text view_notif" data-id="<?php echo $row['id'] . ' ' . $row['type']; ?>"
   										data-heading="<?php echo htmlspecialchars($heading); ?>"
   										style="color: #444444; font-weight: bold;"><?php echo $heading; ?>
									</a>
								<?php elseif($row['type'] == 6): ?>	
									<?php 
										$heading = "[APPOINTMENT] Your request has been successfully submitted";
									?>
									<a href="#" class="filter-text view_notif" data-id="<?php echo $row['id'] . ' ' . $row['type']; ?>"
   										data-heading="<?php echo htmlspecialchars($heading); ?>"
   										style="color: #444444; font-weight: bold;"><?php echo $heading; ?>
									</a>					
								<?php else: ?>
									<a href="#" class="filter-text view_notif" data-id="<?php echo $row['id']; ?>"
   										data-heading="<?php echo htmlspecialchars($row['heading']); ?>"
   										style="color: #444444; font-weight: bold;"><?php echo $row['heading']; ?>
									</a>
								<?php endif; ?>

								</div>

							</li>
						<?php endwhile; ?>
						</ul>
					</div>
				</div>
			</div>
			<!-- Table Panel -->
		</div>
	</div>	

</div>
<style>
	
	td{
		vertical-align: middle !important;
	}
	td p{
		margin: unset
	}
	img{
		max-width:100px;
		max-height:150px;
	}
</style>
<script>
	$(document).ready(function(){
		$('table').dataTable()
	})
	$('#topic-list').JPaging({
	    pageSize: 15,
	    visiblePageSize: 10

	  });

	  $('.view_notif').click(function(){
    	
    	var dataId = $(this).attr('data-id').split(' ');
    	var id = dataId[0]; 
    	var type = dataId[1]; 

    	var heading = $(this).data('heading');

    	view_modal(heading, "social_interaction/view_notif.php?id=" + id + "&type=" + type, 'mid-large');
	});


	function delete_topic($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_topic',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp==1){
					alert_toast("Data successfully deleted",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	}
</script>
