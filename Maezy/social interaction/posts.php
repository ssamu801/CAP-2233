<?php include('db_connect.php');?>

<?php
if(isset($_GET['id'])){
    $category_id = $_GET['id'];
    $category = $conn->query("SELECT * FROM categories WHERE id = $category_id");

    if($category->num_rows > 0){
        $cat_details = $category->fetch_assoc();
    } else {
        echo "Category not found.";
        exit();
    }
} else {
    echo "No category ID provided.";
    exit();
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
					<b>Posts on "<?php echo $cat_details['name']?>" Category</b> <!--topic list -->
						<span class="">

							<button class="btn navbar-color btn-block text-white btn-sm col-sm-2 float-right" type="button" id="new_topic">
					<i class="fa fa-plus"></i> Create Post</button> <!-- create topic -->
				</span>
					</div>
					<div class="card-body">
						<ul class="w-100 list-group" id="topic-list">
							<?php
                            $category_id = $cat_details['id'];
							$tag = $conn->query("SELECT * FROM categories order by name asc");
							while($row= $tag->fetch_assoc()):
								$tags[$row['id']] = $row['name'];
							endwhile;
							$topic = $conn->query("SELECT t.*,u.name 
                                                   FROM topics t 
                                                   INNER JOIN users u ON u.id = t.user_id
                                                   INNER JOIN categories c ON t.category_ids=c.id 
                                                   WHERE t.status='Approved' 
                                                   AND c.id=$category_id
                                                   ORDER BY unix_timestamp(date_created) DESC");
							while($row= $topic->fetch_assoc()):
								$trans = get_html_translation_table(HTML_ENTITIES,ENT_QUOTES);
						        unset($trans["\""], $trans["<"], $trans[">"], $trans["<h2"]);
						        $desc = strtr(html_entity_decode($row['content']),$trans);
						        $desc=str_replace(array("<li>","</li>"), array("",","), $desc);
						        $view = $conn->query("SELECT * FROM forum_views where topic_id=".$row['id'])->num_rows;
						        $comments = $conn->query("SELECT * FROM comments where status='Approved' AND topic_id=".$row['id'])->num_rows;
						        $replies = $conn->query("SELECT * FROM replies where comment_id in (SELECT id FROM comments where topic_id=".$row['id'].")")->num_rows;
							?>
							<li class="list-group-item mb-4">
								<div>
									<?php if($_SESSION['login_id'] == $row['user_id'] || $_SESSION['login_type'] == 1): ?>
					                    <div class="dropleft float-right mr-4">
					                      <a class="text-dark" href="javascript:void(0)" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					                        <span class="fa fa-ellipsis-v"></span>
					                      </a>
					                      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
					                        <a class="dropdown-item edit_topic" data-id="<?php echo $row['id'] ?>" href="javascript:void(0)">Edit</a>
					                        <a class="dropdown-item delete_topic" data-id="<?php echo $row['id'] ?>" href="javascript:void(0)">Delete</a>
					                      </div>
					                    </div> 	
									<?php else: ?>	
										<div class="dropleft float-right mr-4">
					                      <a class="text-dark" href="javascript:void(0)" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					                        <span class="fa fa-ellipsis-v"></span>
					                      </a>
					                      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
					                        <a class="dropdown-item report_topic" data-id="<?php echo $row['id'] ?>" href="javascript:void(0)">Report Post</a>
					                      </div>
					                    </div> 	
				                    <?php endif; ?>
				                    <span class="float-right mr-4"><small><i>Created: <?php echo date('M d, Y h:i A',strtotime($row['date_created'])) ?></i></small></span>
									<a href="index.php?page=social_interaction/view_forum&id=<?php echo $row['id'] ?>"
									 class=" filter-text"><?php echo $row['title'] ?></a>

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
								<span class="float-left badge badge-primary text-white"><i class="fa fa-comments"></i> <?php echo number_format($comments) ?> comment/s <?php echo $replies > 0 ? " and ".number_format($replies).' replies':'' ?> </span>
								<span class="float-right">
									<span>Tags: </span>
								<?php 
								foreach(explode(",",$row['category_ids']) as $cat):
								?>
								<span class="badge badge-info text-white ml-2"><?php echo $tags[$cat] ?></span>
							<?php endforeach; ?>
								</span>
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

	$('#new_topic').click(function(){
		uni_modal("New Entry","social_interaction/manage_topic.php",'mid-large')
	})
	
	$('.edit_topic').click(function(){
		uni_modal("Edit Topic","social_interaction/manage_topic.php?id="+$(this).attr('data-id'),'mid-large')
		
	})
	$('.delete_topic').click(function(){
		_conf("Are you sure to delete this topic?","delete_topic",[$(this).attr('data-id')],'mid-large')
	})

	$('.report_topic').click(function(){
		uni_modal("Report Post","social_interaction/manage_report_post.php?id="+$(this).attr('data-id'),'mid-large')
		
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
</script>