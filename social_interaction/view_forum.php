<?php include 'db_connect.php' ?>
<?php
$user_id = $_SESSION['login_id'];
error_reporting(E_ERROR | E_PARSE);
if(isset($_GET['id'])){
$qry = $conn->query("SELECT t.*,u.name FROM topics t inner join users u on u.id = t.user_id where t.id= ".$_GET['id']);
foreach($qry->fetch_array() as $k => $val){
	$$k=$val;
}
$order = "asc"; // Default sort order
if (isset($_GET['sort'])) {
    if ($_GET['sort'] == "newest") {
        $order = "desc";
    } elseif ($_GET['sort'] == "oldest") {
        $order = "asc";
    }
}

$comments = $conn->query("SELECT c.*,u.name,u.username FROM comments c inner join users u on u.id = c.user_id where c.status='Approved' and c.topic_id= ".$_GET['id']." order by unix_timestamp(c.date_created) $order");
$com_arr= array();
while($row= $comments->fetch_assoc()){
	$com_arr[] = $row;
}
$replies = $conn->query("SELECT r.*,u.name,u.username FROM replies r inner join users u on u.id = r.user_id where r.comment_id in (SELECT id FROM comments where topic_id= ".$_GET['id'].") order by unix_timestamp(r.date_created) asc");
$rep_arr= array();
while($row= $replies->fetch_assoc()){
	$rep_arr[$row['comment_id']][] = $row;
}
if($user_id != $_SESSION['login_id']){
$chk = $conn->query("SELECT * FROM forum_views where  topic_id=$id and user_id='{$_SESSION['login_id']}' ")->num_rows;
if($chk <= 0){
	$conn->query("INSERT INTO forum_views set  topic_id=$id , user_id='{$_SESSION['login_id']}' ");
}
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
	/* Adjust the overall dropdown width */
	.sort-dropdown {
		position: relative;
		display: inline-block;

	}

	/* Style the dropdown button */
	.sort-dropdown select {
		width: 100%; /* Make the select fill the container */
		padding: 8px 12px;
		font-size: 16px;
		border-radius: 6px;
	
	}

	/* Style the dropdown options */
	.sort-dropdown select option {
		padding: 8px;
	}
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
	.like-button {
    display: inline-flex;
    align-items: center;
    border: 1px solid #e0e0e0;
    border-radius: 4px;
    overflow: hidden;
    padding: 0; /* Remove padding from the form element */
    margin: 0; /* Remove margin from the form element */
	}
	.like-text {
    	padding: 6px 12px;
    	background-color: white;
    	color: #333;
    	font-size: 14px;
    	border: none;
    	border-right: 1px solid #e0e0e0;
    	cursor: pointer;
    	display: flex;
    	align-items: center;
    	text-decoration: none;
    	margin: 0; /* Remove margin from the button */
	}
	.like-text:hover {
    	background-color: #107a32;
    	color: white;
	}
	.bi-hand-thumbs-up {
    	color: black;
	}
	.like-text:hover .bi-hand-thumbs-up {
    	color: white;
	}
	.like-count {
    	padding: 6px 12px;
    	background-color: white;
    	color: #333;
    	font-size: 14px;
	}
	.unlike-button {
    	display: inline-flex;
    	align-items: center;
    	border: 1px solid #e0e0e0;
    	border-radius: 4px;
    	overflow: hidden;
    	padding: 0; /* Remove padding from the form element */
    	margin: 0; /* Remove margin from the form element */
	}
	.unlike-text {
    	padding: 6px 12px;
    	background-color: #107a32;
    	color: white;
    	font-size: 14px;
    	border: none;
    	border-right: 1px solid #e0e0e0;
    	cursor: pointer;
    	display: flex;
    	align-items: center;
    	text-decoration: none;
    	margin: 0; /* Remove margin from the button */
	}
	.unlike-text:hover {
    	background-color: white;
    	color: black;
	}
	.bi-hand-thumbs-up-fill {
    	color: white;
	}
	.unlike-text:hover .bi-hand-thumbs-up-fill {
    	color: black;
	}
	.unlike-count {
    	padding: 6px 12px;
    	background-color: white;
    	color: #333;
    	font-size: 14px;
	}
	.helpbtns {
            display: flex;
            gap: 10px;
        }
	.helpbtns .bi-hand-thumbs-up{
		color: white;
	}
	.helpbtns .bi-hand-thumbs-down{
		color: black;
	}	
	
    .helpful-btn, .unhelpful-btn {
        display: flex;
        align-items: center;
        border: none;
        
        border-radius: 5px;
        font-size: 15px;
        cursor: pointer;
    }
    .helpful-btn {
        background-color: #28a745;
        color: #fff;
    }
	.helpful-btn:hover{
		background-color: #107a32
	}
    .unhelpful-btn {
        background-color: #e0e0e0;
        color: #000;
    }
	.unhelpful-btn:hover .bi-hand-thumbs-down {
        color: white;
    }
    .helpful-btn svg, .unhelpful-btn svg {
        margin-right: 10px;
    }
    .helpbtns .active-btn {
        background-color: #107a32;
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
				<?php if($_SESSION['login_id'] == $row['user_id'] || $_SESSION['login_type'] == 1): ?>
                    <div class="dropleft float-right mr-4" style="position: relative;">
                      <a class="text-dark" href="javascript:void(0)" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="fa fa-ellipsis-v"></span>
                      </a>
                      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item edit_topic" data-id="<?php echo $id ?>" href="javascript:void(0)">Edit</a>
                        <a class="dropdown-item delete_topic" data-id="<?php echo $id ?>" href="javascript:void(0)">Delete</a>
                      </div>
                    </div>
                <?php endif; ?>
                <span class="float-right mr-4"><small><i><?php echo date('M d, Y h:i A',strtotime($date_created)) ?></i></small></span>
				<?php if($isAnonymous == 1): ?>
                 <span class="float-right mr-4 text-primary"><small><i>Posted By: Anonymous</i></small></span>
				 <?php endif; ?>
				 <?php if($isAnonymous == 0): ?>
                 <span class="float-right mr-4 text-primary"><small><i>Posted By: <?php echo ucwords($name) ?></i></small></span>
				 <?php endif; ?>
                 <div class="col-md-8">
					<h4><b><?php echo $title ?></b></h4>
				</div>
				<?php if(count($tags) > 0): ?>
				<div>
					<span class="badge badge-default"><i class="fa fa-tags"></i> Tags: </span>
				<?php foreach(explode(',',$category_ids) as $t): ?>
					<span class="badge badge-info text-white"><?php echo $tags[$t] ?></span>
				<?php endforeach; ?>

				</div>
				<?php endif; ?>
				<hr>
				<div class="w-100">
			<!--	<span class="badge badge-secondary text-white"><?php echo number_format($view) ?> view/s</span> -->
				<span class="badge badge-primary text-white ml-2"><i class="fa fa-comments"></i> <?php echo number_format(count($com_arr)) ?> comment/s</span>
				</div>
				<div id="content" class="w-100 mt-4 ml-2">
					<?php echo html_entity_decode($content) ?>
				</div>
				<?php 
				$login_id = $_SESSION['login_id'];
					$like = $conn->query("SELECT * FROM post_likes WHERE post_id=$id AND user_id=$login_id");
					$isLiked = mysqli_num_rows($like);
					if($isLiked == 0):
				?>
				<form action="" id="like-post" class="like-button mt-4 ml-2">
					<input type="hidden" name="id" value="<?php echo $id ?>" class="form-control">
					<input type="hidden" name="user_id" value="<?php echo $login_id ?>" class="form-control">
    				<button type="submit" class="like-text">
        				<i class="bi bi-hand-thumbs-up"></i><span class="ml-1">Like</span>
    				</button>
    				<div class="like-count">
						<?php 
							$total = 0;
							$likes = $conn->query("SELECT * FROM post_likes WHERE post_id=$id");
							$total = mysqli_num_rows($likes);
													
						?>
        				<span class="ml-1"><?php echo $total ?></span>
    				</div>
				</form>
				<?php else: ?>
					<form action="" id="unlike-post" class="unlike-button mt-4 ml-2">
						<input type="hidden" name="id" value="<?php echo $id ?>" class="form-control">
						<input type="hidden" name="user_id" value="<?php echo $login_id ?>" class="form-control">
    					<button type="submit" class="unlike-text">
        					<i class="bi bi-hand-thumbs-up-fill"></i><span class="ml-1">Liked</span>
    					</button>
    				<div class="like-count">
						<?php 
							$total = 0;
							$likes = $conn->query("SELECT * FROM post_likes WHERE post_id=$id");
							$total = mysqli_num_rows($likes);
													
						?>
        				<span class="ml-1"><?php echo $total ?></span>
    				</div>
				</form>
				<?php endif; ?>	
			</div>
		</div>
		<div class="card">
			<div class="card-body">
    		<div class="col-lg-12">
				
    			<div class="row">
    				<h3><b> <i class="fa fa-comments"></i> Comment/s</b></h3>
    			</div>
				<div class="sort-dropdown" class="col-lg-12 mb-4">
					<select id="sort-comments" class="form-control" onchange="sortComments()">
						<option value="newest" <?php echo isset($_GET['sort']) && $_GET['sort'] == 'newest' ? 'selected' : '' ?>>Newest First</option>
						<option value="oldest" <?php echo isset($_GET['sort']) && $_GET['sort'] == 'oldest' ? 'selected' : '' ?>>Oldest First</option>
					</select>
				</div>
    			<?php 
    			foreach($com_arr as $row):
    			?>
    			<div class="form-group comment">
                    <?php if($_SESSION['login_id'] == $row['user_id']): ?>
                    <div class="dropleft float-right">
                      <a class="text-dark" href="javascript:void(0)" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="fa fa-ellipsis-v"></span>
                      </a>
                      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item edit_comment" data-id="<?php echo $row['id'] ?>" href="javascript:void(0)">Edit</a>
                        <a class="dropdown-item delete_comment" data-id="<?php echo $row['id'] ?>" href="javascript:void(0)">Delete</a>
                      </div>
                    </div>
                    <?php endif; ?>
	                <span class="float-right mr-4"><small><i>Created: <?php echo date('M d, Y h:i A',strtotime($row['date_created'])) ?></i></small></span>

    				<p class="mb-3"><large><b><?php echo $row['name'] ?></b></large>  <span class="text-primary"><small class="mb-0"><i><?php echo $row['username'] ?></i></small></span></p>
    				
    				<?php echo html_entity_decode($row['comment']) ?>
    				<div>
    				<!--	<span><button class="float-right btn btn-default btn-sm c_reply" data-id='<?php echo $row['id'] ?>'><i class="fa fa-reply"></i></button></span> -->
					<?php 
						$comment_id = $row['id'];
						$helpful = $row['helpful'];
						$unhelpful = $row['unhelpful'];
						$result = $conn->query("SELECT id, rating_type FROM comment_ratings WHERE user_id = " . $_SESSION['login_id'] . " AND comment_id = " . $row['id']);
						 if ($result->num_rows > 0) {
							 $row = $result->fetch_assoc();
							 if ($row['rating_type'] === 'helpful') {
					?>			
								<div class="helpbtns mt-2" data-comment-id="<?php echo $comment_id ?>">
									<button class="btn-primary helpful-btn active-btn">
										<i class="bi bi-hand-thumbs-up-fill mr-2"></i> Helpful <span class="helpful-count ml-2"> <?php echo $helpful ?></span>
									</button>
									<button class="btn-secondary unhelpful-btn">
										<i class="bi bi-hand-thumbs-down mr-2"></i> Unhelpful <span class="unhelpful-count ml-2"> <?php echo $unhelpful ?></span>
									</button>
								</div>
					<?php			 
							 } else {
					?>			
								 <div class="helpbtns mt-2" data-comment-id="<?php echo $comment_id ?>">
									<button class=" btn-primary helpful-btn">
										<i class="bi bi-hand-thumbs-up mr-2"></i> Helpful <span class="helpful-count ml-2"> <?php echo $helpful ?></span>
									</button>
									<button class=" btn-secondary unhelpful-btn active">
										<i class="bi bi-hand-thumbs-down-fill mr-2"></i> Unhelpful <span class="unhelpful-count ml-2"> <?php echo $unhelpful ?></span>
									</button>
								</div>
					<?php
							 }
						}
						else{
					?>
							<div class="helpbtns mt-2" data-comment-id="<?php echo ($row['id']) ?>">
								<button class="btn-primary helpful-btn">
									<i class="bi bi-hand-thumbs-up mr-2"></i> Helpful <span class="helpful-count ml-2"> <?php echo ($row['helpful']) ?></span>
								</button>
								<button class=" btn-secondary unhelpful-btn">
									<i class="bi bi-hand-thumbs-down mr-2"></i> Unhelpful <span class="unhelpful-count ml-2"> <?php echo ($row['unhelpful']) ?></span>
								</button>
							</div>
					<?php
						}
								
					?>
    				<!--	<span class="text-primary ml-4"><?php echo isset($rep_arr[$row['id']]) ? count($rep_arr[$row['id']]).(count($rep_arr[$row['id']]) > 1? ' Replies':' Replied') : '' ?></span> -->

    					<?php if(isset($rep_arr[$row['id']])): ?>
    						<hr>
    					<div class="col-lg-8 offset-lg-2 replies">
    						<a href="javascript:void(0)" class="show_all" style="display: none">Show all replies</a>
    						<?php 
    						
    							foreach($rep_arr[$row['id']] as $rep):
    						?>
    						<div class="form-group ty-compact-list">
			                    <?php if($_SESSION['login_id'] == $rep['user_id']): ?>
			                    <div class="dropleft float-right">
			                      <a class="text-dark" href="javascript:void(0)" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			                        <span class="fa fa-ellipsis-v"></span>
			                      </a>
			                      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
			                        <a class="dropdown-item edit_reply" data-id="<?php echo $rep['id'] ?>" href="javascript:void(0)">Edit</a>
			                        <a class="dropdown-item delete_reply" data-id="<?php echo $rep['id'] ?>" href="javascript:void(0)">Delete</a>
			                      </div>
			                    </div>
			                    <?php endif; ?>
				                <span class="float-right mr-4"><small><i>Created: <?php echo date('M d, Y h:i A',strtotime($rep['date_created'])) ?></i></small></span>

			    				<p class="mb-0"><large><b><?php echo $rep['name'] ?></b></large>  <span class="text-primary"><small class="mb-0"><i><?php echo $rep['username'] ?></i></small></span></p>
			    				
			    				<br>
			    				<?php echo html_entity_decode($rep['reply']) ?>
			    				<hr>
			    			</div>
    					<?php endforeach; ?>
    					</div>
    					<?php endif; ?>

    				</div>
    				<hr>
    			</div>
    		<?php endforeach; ?>
    		</div>
    			<div class="col-lg-12">
    				<form action="" id="manage-comment">
    					<div class="form-group">
    						<input type="hidden" name="id" value="">
    						<input type="hidden" name="topic_id" value="<?php echo isset($id) ? $id : '' ?>">
    						<textarea class="form-control jqte" id="comment-txt" name="comment" cols="30" rows="5" placeholder="New Comment"></textarea>
    					</div>
    					<button class="btn btn-success">Save Comment</button>
    				</form>
    			</div>
    	</div>
		</div>
		</div>
	</div>
</div>
<div id="reply_clone" style="display: none;">
	<div class="col-lg-8 offset-lg-2 reply-field">
		<hr>
		<form action="" id="">
			<div class="form-group">
				<input type="hidden" name="id" value="">
				<input type="hidden" name="comment_id" value="">
				<textarea class="form-control" name="" cols="30" rows="5" placeholder="New Reply"></textarea>
			</div>
			<button class="btn btn-primary">Reply</button>
		</form>
	</div>
</div>
<script>
	$('.jqte').jqte()
	$('.edit_topic').click(function(){
		uni_modal("Edit Topic","social_interaction/manage_topic.php?id="+$(this).attr('data-id'),'mid-large')
		
	})
	$('.edit_comment').click(function(){
		uni_modal("Edit Comment","social_interaction/manage_comment.php?id="+$(this).attr('data-id'),'mid-large')
		
	})
	$('.edit_reply').click(function(){
		uni_modal("Edit Reply","social_interaction/manage_reply.php?id="+$(this).attr('data-id'),'mid-large')
		
	})
	// function _compact(){
		$('.replies').each(function(){
			if ($(this).find('.ty-compact-list').length > 4) {
				var i = $(this).find('.ty-compact-list').length - 5;
				for(i; i >= 0 ; i--){
				$(this).find('.ty-compact-list:nth("'+i+'")').hide()
				}
			  $(this).find('.show_all').show();
			}

		})
				$('.replies .show_all').click(function(){
			var i = $(this).siblings('.ty-compact-list').length - 5;
			for(i; i >= 0 ; i--){
			$(this).siblings('.ty-compact-list:nth("'+i+'")').toggle()
			}
			if($(this).text() == 'Show all replies')
				$(this).text('Show less')
			else
				$(this).text('Show all replies')
		})
	// }
	$('.c_reply').click(function(){
		if($('.reply-field[data-id="'+$(this).attr('data-id')+'"]').length >0){
			return false;
		}else{
			$('.comment .reply-field').remove()
		}
		var rtf= $('#reply_clone .reply-field').clone()
		rtf.find('form').attr('id','manage-reply')
		rtf.find('[name="comment_id"]').val($(this).attr('data-id'))
		rtf.find('textarea').attr({'name':"reply",'id':"reply-txt"}).jqte()
		rtf.attr('data-id',$(this).attr('data-id'))
		if($(this).parent().parent().find('.replies').length > 0)
		$(this).parent().parent().find('.replies').parent().after(rtf)
		else
		$(this).parent().append(rtf)
		submit_reply_func()
	})
	$('.delete_topic').click(function(){
		_conf("Are you sure to delete this topic?","delete_topic",[$(this).attr('data-id')],'mid-large')
	})
	function delete_topic($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_topic',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp==1){
					alert_toast("Post successfully deleted",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	}
	function submit_reply_func(){
		$('#manage-reply').submit(function(e){
			e.preventDefault()
			start_load()
		
			$.ajax({
				url:'ajax.php?action=save_reply',
				method:'POST',
				data:$(this).serialize(),
				success:function(resp){
					if(resp == 1){
						alert_toast("Data successfully saved.",'success')
						setTimeout(function(){
							location.reload()
						},1000)
					}
				}
			})
		})
	}
	$('#manage-comment').submit(function(e){
		e.preventDefault()
		start_load()
		
		$.ajax({
			url:'ajax.php?action=save_comment',
			method:'POST',
			data:$(this).serialize(),
			success:function(resp){
				if(resp == 1){
					alert_toast("Comment submitted. Kindly wait for approval of comment.",'success')
					setTimeout(function(){
						location.reload()
					},1000)
				}
			}
		})
	})
    $('.delete_comment').click(function(){
        _conf("Are you sure to delete this comment?","delete_comment",[$(this).attr('data-id')],'mid-large')
    })

    function delete_comment($id){
        start_load()
        $.ajax({
            url:'ajax.php?action=delete_comment',
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
    $('.delete_topic').click(function(){
        _conf("Are you sure to delete this topic?","delete_topic",[$(this).attr('data-id')],'mid-large')
    })

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
    $('.delete_reply').click(function(){
        _conf("Are you sure to delete this reply?","delete_reply",[$(this).attr('data-id')],'mid-large')
    })

    function delete_reply($id){
        start_load()
        $.ajax({
            url:'ajax.php?action=delete_reply',
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

	$('#like-post').submit(function(e){
		e.preventDefault()
		
		start_load()
		$.ajax({
			url:'ajax.php?action=like_post',
			method:'POST',
			data:$(this).serialize(),
			success:function(resp){
				if(resp == 1){
					setTimeout(function(){
						location.reload()
					},1000)
				}
			}
		})
	})

	$('#unlike-post').submit(function(e){
		e.preventDefault()
		
		start_load()
		$.ajax({
			url:'ajax.php?action=unlike_post',
			method:'POST',
			data:$(this).serialize(),
			success:function(resp){
				if(resp == 1){
					setTimeout(function(){
						location.reload()
					},1000)
				}
			}
		})
	})

	function sortComments() {
		var sortOrder = document.getElementById("sort-comments").value;
		var urlParams = new URLSearchParams(window.location.search);
		urlParams.set('sort', sortOrder);
		window.location.search = urlParams.toString();
	}


	$(document).ready(function() {
            $('.helpful-btn').on('click', function() {
                var commentId = $(this).closest('.helpbtns').data('comment-id');
                $.post('./social_interaction/rate_comment.php', {
                    action: 'helpful',
                    comment_id: commentId
                }, function(response) {
                    if (response.success) {
                        var helpfulCount = response.helpful_count;
                        var unhelpfulCount = response.unhelpful_count;
                        $('div[data-id="'+commentId+'"] .helpful-count').text(helpfulCount);
                        $('div[data-id="'+commentId+'"] .unhelpful-count').text(unhelpfulCount);
                    }
                }, 'json');
				location.reload()
            });

            $('.unhelpful-btn').on('click', function() {
                var commentId = $(this).closest('.helpbtns').data('comment-id');
                $.post('./social_interaction/rate_comment.php', {
                    action: 'unhelpful',
                    comment_id: commentId
                }, function(response) {
                    if (response.success) {
                        var helpfulCount = response.helpful_count;
                        var unhelpfulCount = response.unhelpful_count;
                        $('div[data-id="'+commentId+'"] .helpful-count').text(helpfulCount);
                        $('div[data-id="'+commentId+'"] .unhelpful-count').text(unhelpfulCount);
                    }
                }, 'json');
				location.reload()
            });
        });
</script>

<?php
/*
	lines:
	64-139 css
	188-226 like button
	499-534 ajax for like functions
*/

?>