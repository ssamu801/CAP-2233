<?php include 'db_connect.php' ?>
<?php
error_reporting(E_ERROR | E_PARSE);
if(isset($_GET['id'])){
    $qry = $conn->query("SELECT c.*, u.name, t.title 
                            FROM comments c 
                            INNER JOIN users u ON u.id = c.user_id 
                            INNER JOIN topics t ON t.id = c.topic_id 
                            WHERE c.id=".$_GET['id']);
    foreach($qry->fetch_array() as $k => $val){
        $$k=$val;
    }

$view = $conn->query("SELECT * FROM forum_views where topic_id=$id")->num_rows;
$tags = array();
if(!empty($category_ids)){
$tag = $conn->query("SELECT * FROM categories where id in ($category_ids) order by name asc");
	while($row= $tag->fetch_assoc()):
		$tags[$row['id']] = $row['name'];
	endwhile;
}
}
?>
<style type="text/css">
	
	.avatar {
	    display: flex;
	    border-radius: 100%;
	    width: 100px;
	    height: 100px;
	    align-items: center;
	    justify-content: center;
	    border: 3px solid;
	    padding: 5px;
	}
	.avatar img {
	    max-width: calc(100%);
	    max-height: calc(100%);
	    border-radius: 100%;
	}
	p{
		margin:unset;
	}
	#content{
		max-height: 60vh;
		overflow: auto;
	}
	#content pre	{
		background: #80808091;
		padding:5px;
	}
</style>
<div class="container-field">
<div class="row mb-4 mt-4">
			<div class="col-md-12">
				
			</div>
		</div>
	<div class="col-lg-12">
		<div class="card">
			<div class="card-body">
			
                <span class="float-right mr-4"><small><i><?php echo date('M d, Y h:i A',strtotime($date_created)) ?></i></small></span>
                 <span class="float-right mr-4 text-primary"><small><i>Posted By: <?php echo ucwords($name) ?></i></small></span>
                 <div class="col-md-8">
					<h4><b><?php echo "Comment to: ".$title ?></b></h4>
				</div>

				<hr>
				<div class="w-100">
			<!--	<span class="badge badge-secondary text-white"><?php echo number_format($view) ?> view/s</span> -->
				</div>
				<div id="content" class="w-100 mt-4">
					<?php echo html_entity_decode($comment) ?>
				</div>
                <hr>
                <span class="float-left"><strong>Words Detected: </strong></span>
								<br>
								<span class="float-left mr-1"><small><i>
								<?php
									$stmt = $conn->query("SELECT word FROM word_bank");
									$wordsToDetect = [];
									while ($row = $stmt->fetch_assoc()) {
										$wordsToDetect[] = $row['word'];
									}
									
									$text = html_entity_decode($comment);
									
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
			</div>
            <div class="text-center mb-3"> <!-- Add this div for centering buttons -->
			
                <button class="btn btn-success btn-sm ml-2 accept" data-id="<?php echo $id . ' ' . $user_id; ?>">Accept</button>
                <button class="btn btn-secondary btn-sm ml-2" id="decline" data-id="<?php echo $id ?>">Decline</button>
            </div>
		</div>
		
		</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
    $('table').dataTable();
    

    $('.accept').click(function(){
		var dataId = $(this).attr('data-id').split(' ');
		console.log(dataId);
        _conf("Approve this comment?","approve_comment",dataId,'mid-large'); 
    });

	$('#decline').click(function(){
		uni_modal("Decline Comment","social_interaction/decline_comment.php?id="+$(this).attr('data-id'),'mid-large')
	})
});

function approve_comment(id, commenterID){
	var login_name = '<?php echo $_SESSION['login_name']; ?>'; 
    start_load();
    $.ajax({
        url: 'ajax.php?action=approve_comment',
        method: 'POST',
        data: { id: id, login_name: login_name, commenter_id: commenterID },
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