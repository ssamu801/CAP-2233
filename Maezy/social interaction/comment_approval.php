<?php include('db_connect.php');?>

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
					<b>Pending Comments</b>
					</div>
					<div class="card-body">
						<ul class="w-100 list-group" id="topic-list">
							<?php
							$comment = $conn->query("SELECT c.*, u.name, t.title 
													FROM comments c 
													INNER JOIN users u ON u.id = c.user_id 
													INNER JOIN topics t ON t.id = c.topic_id 
													WHERE c.status = 'Pending' 
													ORDER BY UNIX_TIMESTAMP(c.date_created) DESC;");
							while($row= $comment->fetch_assoc()):
								$trans = get_html_translation_table(HTML_ENTITIES,ENT_QUOTES);
						        unset($trans["\""], $trans["<"], $trans[">"], $trans["<h2"]);
						        $desc = strtr(html_entity_decode($row['comment']),$trans);
						        $desc=str_replace(array("<li>","</li>"), array("",","), $desc);
							?>
							<li class="list-group-item mb-4">
								<div>
									
				                    <span class="float-right mr-1"><small><i>Created: <?php echo date('M d, Y h:i A',strtotime($row['date_created'])) ?></i></small>
                                        <button class="btn btn-success btn-sm ml-2" id="accept" data-id="<?php echo $row['id'] ?>">Accept</button>
                                        <button class="btn btn-secondary btn-sm ml-2" id="decline" data-id="<?php echo $row['id'] ?>">Decline</button>
                                    </span>
									<a href="index.php?page=social_interaction/view_pending_comment&id=<?php echo $row['id'] ?>"
									 class=" filter-text">Comment to: <?php echo $row['title'] ?></a>

								</div>
								<hr>
								<p class="truncate filter-text"><?php echo strip_tags($desc) ?></p>    
    								<p class="row float-right mr-1"><span class="badge badge-success text-white"><i>Posted By: <?php echo $row['name'] ?></i></span></p>
									<br>
								
								<hr>
								
							<!--	<span class="float-left badge badge-secondary text-white"><?php echo number_format($view) ?> view/s</span> -->
                                <span class="float-left"><strong>Words Detected: </strong></span>
								<br>
								<span class="float-left mr-1"><small><i>
								<?php
									$stmt = $conn->query("SELECT word FROM word_bank");
									$wordsToDetect = [];
									while ($row = $stmt->fetch_assoc()) {
										$wordsToDetect[] = $row['word'];
									}
									
									$text = strip_tags($desc);
									
									$i = 0;
									foreach ($wordsToDetect as $word) {
										if (stripos($text, $word) !== false) {
											echo $word." " ;
											$i++;
										} 
									}
									
									if ($i == 0) {
										echo "None detected.";
									}
									
								?>
								</i></small>
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
    $('table').dataTable();
    

    $('#accept').click(function(){
        _conf("Approve this comment?","approve_comment",[$(this).attr('data-id')],'mid-large'); 
    });

	$('#decline').click(function(){
		uni_modal("Decline comment","social_interaction/decline_comment.php?id="+$(this).attr('data-id'),'mid-large')
	})
});

function approve_comment(id){
	var login_name = '<?php echo $_SESSION['login_name']; ?>'; 
    start_load();
    $.ajax({
        url: 'ajax.php?action=approve_comment',
        method: 'POST',
        data: { id: id, login_name: login_name },
        success: function(resp){
            if(resp == 1){
                alert_toast("Comment approved", 'success');
                setTimeout(function(){
                    window.location.href = 'index.php?page=social_interaction/comment_approval'; 
                }, 1500);
            }
        }
    });
}

</script>