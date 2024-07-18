<?php include('db_connect.php');

	// Fetch categories from the database
	$query = "SELECT id, name FROM categories";
	$result = $conn->query($query);

	$categories = [];
	if ($result->num_rows > 0) {
		while ($row = $result->fetch_assoc()) {
			$categories[] = $row;
		}
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

	#tagIcon {
    background-color: #f8f9fa;
    border: 1px solid #ced4da;
	}

	.input-group-text {
		border-top-right-radius: 0.25rem;
		border-bottom-right-radius: 0.25rem;
	}

	.form-group {
		padding: 5px;
	}

	.tag-btn {
		margin: 2px;	
	}

	.fa-tag {
        margin: 5px;
    }

	#searchQuery {
		width: 100%;
	}

</style>

<div class="col-lg-12">
		<div class="row mb-4 mt-4">
			<div class="col-md-12">
				
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="card">
					<div class="card-header d-flex justify-content-between align-items-center">
						<b>Articles</b>
						<?php if($_SESSION['login_type'] == 1): ?>
							<span>
								<button class="btn navbar-color btn-sm" type="button" id="new_media">
									<i class="fa fa-plus"></i> Add Article
								</button>
							</span>
						<?php endif; ?>

						<!-- Advanced Search function -->
						<div class="form-inline">
							<button type="button" class="btn btn-outline-success" id="advancedSearchBtn" data-toggle="modal" data-target="#exampleModalCenter">
								<i class="fas fa-search"></i> Advanced Search
							</button>

							<!-- Modal -->
							<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
								<div class="modal-dialog modal-dialog-centered" role="document">
									<div class="modal-content">
										<div class="modal-header d-flex justify-content-center">
											<h5 class="modal-title" id="exampleModalLongTitle" style="font-weight: 700; font-size: 24px;">Advanced Search</h5>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
											</button>
										</div>
										<div class="modal-body">
											<form id="manage-search" action="search2.php">
												<input type="text" placeholder="Search" class="form-control" id="searchBtn" value="<?php echo isset($_GET['keyword'])? $_GET['keyword'] :'' ?>">
											<div class="form-group">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="tagIcon"><i class="fa fa-tag"></i></span>
                                                    </div>
                                                    <input type="text" placeholder="Tags" class="form-control" id="tagsInput" value="<?php echo isset($_GET['tag'])? $_GET['tag'] :'' ?>">
                                                </div>
                                            </div>
											</form>
											<div class="form-group">
											<!-- Display category names from db -->
											<?php foreach ($categories as $category): ?>
												<button class="btn btn-info tag-btn" data-tag="<?php echo htmlspecialchars($category['name']); ?>"><?php echo htmlspecialchars($category['name']); ?></button>
											<?php endforeach; ?>
											<!--
												<button class="btn btn-info tag-btn" data-tag="Mental Health">Mental Health</button>
												<button class="btn btn-info tag-btn" data-tag="Advice">Advice</button>
												<button class="btn btn-info tag-btn" data-tag="Information">Information</button>
											-->
											</div>
										</div>
									</div>
								</div>
							</div>

						</div>
					</div>
					<div class="card-body">
						<ul class="w-100 list-group" id="topic-list">
							<?php
								$tag = $conn->query("SELECT * FROM categories ORDER BY name ASC");
								if (!$tag) {
									die("Error fetching categories: " . $conn->error);
								}
								while ($row = $tag->fetch_assoc()) {
									$tags[$row['id']] = $row['name'];
								}

								$article = $conn->query("SELECT * FROM articles order by title asc");
								if (!$article) {
                                    die("Error fetching article: " . $conn->error);
                                }
								while($row= $article->fetch_assoc()){
									$comments = $conn->query("SELECT * FROM article_comments where article_id=".$row['article_id'])->num_rows;

									$article_tags = array();
									if (!empty($row['category_ids'])) {
										$category_ids = explode(',', $row['category_ids']);
										foreach ($category_ids as $cat_id) {
										if (isset($tags[$cat_id])) {
											$article_tags[] = $tags[$cat_id];
											}
										}
									}
							?>
								<li class="list-group-item mb-4">
									<div>
										<?php if($_SESSION['login_type'] == 1): ?>
											<div class="dropleft float-right mr-4">
											<a class="text-dark" href="javascript:void(0)" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
												<span class="fa fa-ellipsis-v"></span>
											</a>
											<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
												<a class="dropdown-item edit_topic" data-id="<?php echo $row['article_id'] ?>" href="javascript:void(0)">Edit</a>
												<a class="dropdown-item delete_topic" data-id="<?php echo $row['article_id'] ?>" href="javascript:void(0)">Delete</a>
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
										<span class="float-right mr-4"><small><i>Created: <?php echo date('M d, Y h:i A',strtotime($row['added_at'])) ?></i></small></span>
										<a href="index.php?page=information_resources/view_article&id=<?php echo $row['article_id'] ?>"
										class=" filter-text"><?php echo $row['title'] ?></a>
									</div>

									<hr>

									<span class="float-left badge badge-primary text-white"><i class="fa fa-comments"></i> <?php echo number_format($comments) ?> comment/s </span>
									<span class="float-right">
										<span class="badge badge-default"><i class="fa fa-tags"></i> Tags: </span>
										<?php 
											foreach(explode(",",$row['category_ids']) as $cat):
											?>
											<span class="badge badge-info text-white"><?php echo $tags[$cat] ?></span>
										<?php endforeach; ?>
									</span>
								</li>
							<?php } ?>
						</ul>
					</div>
				</div>
			</div>
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
	});

	$('#topic-list').JPaging({
	    pageSize: 15,
	    visiblePageSize: 10
	});

	$('#new_media').click(function(){
		uni_modal("Article", "information_resources/manage_article.php", 'mid-large');
	});

	$('#searchBtn').keypress(function(e){
		if(e.which == 13){
			$('#manage-search').submit();
		}
	});

	$('#tagsInput').keypress(function(e){
		if(e.which == 13){
			$('#manage-search1').submit();
		}
	});

	$('#manage-search').submit(function(e){
		e.preventDefault();
		location.href = "index.php?page=information_resources/search2&keyword=" + $('#searchBtn').val();
	});

	$('#manage-search1').submit(function(e){
		e.preventDefault();
		location.href = "index.php?page=information_resources/search2&tag=" + $('#tagsInput').val();
	});

	$('.tag-btn').click(function(){
        var tag = $(this).data('tag');
        location.href = "index.php?page=information_resources/search2&tag=" + tag;
    });

	$('#new_topic').click(function(){
		uni_modal("New Entry","information_resources/manage_topic.php",'mid-large')
	})
	
	$('.edit_topic').click(function(){
		uni_modal("Edit Topic","information_resources/manage_topic.php?id="+$(this).attr('data-id'),'mid-large')
		
	})
	$('.delete_topic').click(function(){
		_conf("Are you sure to delete this topic?","delete_topic",[$(this).attr('data-id')],'mid-large')
	})

	$('.report_topic').click(function(){
		uni_modal("Report Post","information_resources/manage_report_post.php?id="+$(this).attr('data-id'),'mid-large')
		
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