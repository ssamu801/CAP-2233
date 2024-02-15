<?php  include('db_connect.php'); ?>
<?php if($_SESSION['login_type'] != 1): ?>
	<script> location.replace("index.php?page=home"); </script>
<?php endif; ?>
<div class="container-fluid">
    <div class="col-lg-12">
	    <div class="row mb-4 mt-4">
		    <div class="col-md-12">
				
		    </div>
	    </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
					<div class="card-header">
						<b>List of Post Reports</b>
						<span class=""></span>
                    </div>
                    <div class="card-body">
						<table class="table table-bordered table-hover">
							<colgroup>
								<col width="80%">
								<col width="20%">
							</colgroup>
							<thead>
								<tr>
									<th class="text-center">Posts</th>
									<th class="text-center">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$report = $conn->query("SELECT u.username, t.content, t.id, pr.date_reported, pr.report_reason FROM post_reports pr JOIN users u on u.id=pr.reporter_id JOIN topics t on pr.post_id = t.id ORDER BY unix_timestamp(date_reported) DESC");
            					while($row = $report->fetch_assoc()):
                					$rawCommentDateTime = $row['date_reported'];
                					$commentDateTimeObj = new DateTime($rawCommentDateTime);
                					$formattedCommentDateTime = $commentDateTimeObj->format('Y-m-d h:i A');
									$trans = get_html_translation_table(HTML_ENTITIES,ENT_QUOTES);
									unset($trans["\""], $trans["<"], $trans[">"], $trans["<h2"]);
									$desc = strtr(html_entity_decode($row['content']),$trans);
			 						$desc=str_replace(array("<li>","</li>"), array("",","), $desc);
								?>
								<tr>
									<td class="">
										<p>Reported By: <b><?php echo $row['username'] ?></b></p>
										<p>Date Reported: <b><?php echo $formattedCommentDateTime?></b></p>
										<p>Content:</p>
										<p class="truncate"><?php echo strip_tags($desc) ?></p>
										
									</td>
									<td class="text-center">
										<button class="btn btn-sm btn-danger delete_post" type="button" data-id="<?php echo $row['id'] ?>">Delete</button>
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
	
	
	$('.delete_post').click(function(){
		_conf("Delete this post?","delete_post",[$(this).attr('data-id')])
	})
	function delete_post($id){
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
	$('table').dataTable()
	$('table').dataTable()
</script>
