<?php include('db_connect.php');?>
<?php
if(  $_SESSION['login_type'] != 4){
	echo '<script type="text/javascript">
	setTimeout(function() {
		window.location.href = "index.php?page=home";
	}, 0000); 
	</script>';
}
?>
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
					<b>Pending Posts</b> <!--topic list -->
					</div>
					<div class="card-body">
						<ul class="w-100 list-group" id="topic-list">
							<?php
							$tag = $conn->query("SELECT * FROM categories order by name asc");
							while($row= $tag->fetch_assoc()):
								$tags[$row['id']] = $row['name'];
							endwhile;
							$topic = $conn->query("SELECT t.*,u.name FROM topics t inner join users u on u.id = t.user_id WHERE t.status='Pending' order by unix_timestamp(date_created) ASC");
							while($row= $topic->fetch_assoc()):
								$trans = get_html_translation_table(HTML_ENTITIES,ENT_QUOTES);
						        unset($trans["\""], $trans["<"], $trans[">"], $trans["<h2"]);
						        $desc = strtr(html_entity_decode($row['content']),$trans);
						        $desc=str_replace(array("<li>","</li>"), array("",","), $desc);
						        $view = $conn->query("SELECT * FROM forum_views where topic_id=".$row['id'])->num_rows;
						        $comments = $conn->query("SELECT * FROM comments where topic_id=".$row['id'])->num_rows;
						        $replies = $conn->query("SELECT * FROM replies where comment_id in (SELECT id FROM comments where topic_id=".$row['id'].")")->num_rows;
							?>
							<li class="list-group-item mb-4">
								<div>
					                <div class="dropleft float-right ml-3">
					                	<a class="text-dark" href="javascript:void(0)" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					                        <span class="fa fa-ellipsis-v"></span>
					                    </a>
					                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
					                    <a class="dropdown-item edit_topic" data-id="<?php echo $row['id'] ?>" href="javascript:void(0)">Edit</a>
					                </div>
					            </div> 	
								<div>
									
				                    <span class="float-right mr-1"><small><i>Created: <?php echo date('M d, Y h:i A',strtotime($row['date_created'])) ?></i></small>
                                        <button class="btn btn-success btn-sm ml-2 accept" id="accept" data-id="<?php echo $row['id'] ?>">Accept</button>
                                        <button class="btn btn-secondary btn-sm ml-2 decline" id="decline" data-id="<?php echo $row['id'] ?>">Decline</button>
                                    </span>
									<a href="index.php?page=social_interaction/view_pending_post&id=<?php echo $row['id'] ?>"
									 class=" filter-text"><?php echo $row['title'] ?></a>

								</div>
                                <div>
                                    <span style="font-size: smaller;"> <i class="bi bi-tags-fill"></i> Tags: </span>
                                        <?php foreach(explode(",",$row['category_ids']) as $cat): ?>
                                            <span class="badge badge-info text-white ml-2"><?php echo $tags[$cat] ?></span>
                                        <?php endforeach; ?>
                                </div>
								<hr>
								<p class="truncate filter-text"><?php echo strip_tags($desc) ?></p>
								<?php if($row['isAnonymous'] == 1): ?>
    								<p class="row justify-content-left mr-1"><span class="badge badge-success text-white"><i>Posted anonymously</i></span></p>
								<?php else: ?>    
    								<p class="row float-right mr-1"><span class="badge badge-success text-white"><i>Posted By: <?php echo $row['name'] ?></i></span></p>
									<br>
								<?php endif; ?>
								
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
    

    $('.accept').click(function(){
        _conf("Approve this post?","approve_topic",[$(this).attr('data-id')],'mid-large'); 
    });

	$('.decline').click(function(){
		uni_modal("Decline Post","social_interaction/decline_topic.php?id="+$(this).attr('data-id'),'mid-large')
	})

	$('.edit_topic').click(function(){
		uni_modal("Edit Topic","social_interaction/manage_topic_mod.php?id="+$(this).attr('data-id'),'mid-large')
		
	})
});



function approve_topic(id){
	var login_name = '<?php echo $_SESSION['login_name']; ?>'; 
    start_load();
    $.ajax({
        url: 'ajax.php?action=approve_topic',
        method: 'POST',
        data: { id: id, login_name: login_name },
        success: function(resp){
            if(resp == 1){
                alert_toast("Post approved", 'success');
                setTimeout(function(){
                    location.reload();
                }, 1500);
            }
        }
    });
}

</script>