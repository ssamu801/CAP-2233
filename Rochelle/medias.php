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
						<b>Media Resources</b>
						<?php if($_SESSION['login_type'] == 1): ?>
							<span>
								<button class="btn navbar-color btn-sm" type="button" id="new_media">
									<i class="fa fa-plus"></i> Add Photos/Videos
								</button>
							</span>
						<?php endif; ?>

						<!-- Advanced Search function -->
						<div class="form-inline">
							<button type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#exampleModalCenter">
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
											<form id="manage-search">
												<input type="text" placeholder="Search" class="form-control" id="searchBtn" value="<?php echo isset($_GET['keyword'])? $_GET['keyword'] :'' ?>">
												<div class="form-group">
													<div class="input-group">
														<div class="input-group-prepend">
															<span class="input-group-text" id="tagIcon"><i class="fa fa-tag"></i></span>
														</div>
														<input type="text" placeholder="Tags" class="form-control tags" id="tagsInput" value="<?php echo isset($_GET['tag'])? $_GET['tag'] :'' ?>">
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

                                $media = $conn->query("SELECT upload_id AS file_id, MAX(title) AS name, MAX(category_ids) AS category_ids, 'File' AS type
                                                      FROM media_files 
                                                      GROUP BY upload_id
                                                      UNION 
                                                      SELECT video_id AS file_id, MAX(title) AS name, MAX(category_ids) AS category_ids, 'Video' AS type
                                                      FROM embed_videos 
                                                      GROUP BY video_id
                                                      ORDER BY name ASC;");
                                if (!$media) {
                                    die("Error fetching media: " . $conn->error);
                                }
                                while ($row = $media->fetch_assoc()) {
                                    $view = $conn->query("SELECT * FROM resources_views WHERE article_id=" . $row['file_id']);
                                    $view_count = ($view) ? $view->num_rows : 0;

                                    $comments = $conn->query("SELECT * FROM embed_comments WHERE embed_id=" . $row['file_id']);
                                    $comments_count = ($comments) ? $comments->num_rows : 0;

                                    $media_tags = array();
                                    if (!empty($row['category_ids'])) {
                                        $category_ids = explode(',', $row['category_ids']);
                                        foreach ($category_ids as $cat_id) {
                                            if (isset($tags[$cat_id])) {
                                                $media_tags[] = $tags[$cat_id];
                                            }
                                        }
                                    }
                            ?>
                                <li class="list-group-item mb-4">
                                    <div>
                                        <a href="index.php?page=information_resources/view_media&id=<?php echo $row['file_id'] ?>&type=<?php echo $row['type'] ?>" class="filter-text"><?php echo $row['name'] ?></a>
                                        <span class="float-right">
                                            <!-- Average Rating: display average rating here -->
                                        </span>
                                    </div>
                                    <hr>
                                    <span class="float-left badge badge-primary text-white"><i class="fa fa-comments"></i> <?php echo number_format($comments_count) ?> comment/s</span>
                                    <span class="float-right">
										<span class="badge badge-default"><i class="fa fa-tags"></i> Tags: </span>
                                        <!-- Display tags here -->
										<?php foreach ($media_tags as $tag): ?>
                                            <span class="badge badge-info text-white"><?php echo $tag ?></span>
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
	td {
		vertical-align: middle !important;
	}
	td p {
		margin: unset;
	}
	img {
		max-width: 100px;
		max-height: 150px;
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
		uni_modal("Media", "information_resources/manage_media.php", 'mid-large');
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
		location.href = "index.php?page=information_resources/search&keyword=" + $('#searchBtn').val();
	});

	$('#manage-search1').submit(function(e){
		e.preventDefault();
		location.href = "index.php?page=information_resources/search&tag=" + $('#tagsInput').val();
	});

	$('.tag-btn').click(function(){
        var tag = $(this).data('tag');
        location.href = "index.php?page=information_resources/search&tag=" + tag;
    });
</script>