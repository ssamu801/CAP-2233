<?php
    include('admin_class.php');
    $action = new Action();
    $data = $action->search2();
    error_log("Search data: " . print_r($data, true));

    include('db_connect.php');

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

<style>
    .col-lg-12 {
        padding-top: 20px;
    }

    input[type=checkbox] {
        -ms-transform: scale(1.5);
        -moz-transform: scale(1.5);
        -webkit-transform: scale(1.5);
        -o-transform: scale(1.5);
        transform: scale(1.5);
        padding: 10px;
    }
    .list-group-item + .list-group-item {
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
        padding: 2px;
    }

	.tag-btn {
		margin: 2px;	
	}

    .badge-info {
        margin: 2px;
    }

    .fa-tag {
        margin: 2px;
    }

    #searchQuery {
        width: 100%;
    }

    .badge-primary {
        background-color: #007bff;
    }
</style>

<div class="container-fluid">
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
                    <div class="card-body" id="search_result">
                        <div id="preloader3"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<ul id="clone-ul" style="display: none">
    <li class="list-group-item mb-4">
        <div>
            <a href="" class="filter-text title name"></a>
            <span class="float-right">
                <!-- Average Rating: display average rating here -->
            </span>
        </div>
        <hr>
        <span class="float-left badge badge-primary text-white"><i class="fa fa-comments"></i> <span class="comments"></span> comment/s</span>
        <span class="float-right">
            <span class="badge badge-default"><i class="fa fa-tags"></i> Tags: </span>
                <!-- display tags here -->
        </span>
    </li>
</ul>

<script>
    window.load_search = function() {
        $.ajax({
            url: 'ajax.php?action=search2',
            method: 'POST',
            data: { 
                keyword: '<?php echo isset($_GET['keyword']) ? $_GET['keyword'] : '' ?>',
                tag: '<?php echo isset($_GET['tag']) ? $_GET['tag'] : '' ?>'
            },
            success: function(resp) {
                $('#preloader3').hide();
                if (resp) {
                    resp = JSON.parse(resp);
                    if (resp.length > 0) {
                        var ul = $('<ul class="w-100 list-group" id="topic-list"></ul>');
                        resp.forEach(item => {
                            var li = $('#clone-ul li').clone();
                            li.find('.title').text(item.title);
                            li.find('.title').attr('href', 'index.php?page=information_resources/view_article&id='+item.article_id);
                            li.find('.comments').text(item.comments);
                            
                            if (item.article_tags && item.article_tags.length > 0) {
                                item.article_tags.forEach(tag => {
                                    var tagBadge = $('<span class="badge badge-info text-white"></span>').text(tag);
                                    li.find('.badge-default').after(tagBadge);
                                });
                            }

                            ul.append(li);
                        });
                        $('#search_result').html(ul);
                        $('#topic-list').JPaging({
                            pageSize: 15,
                            visiblePageSize: 10
                        });
                    } else {
                        $('#search_result').html('<h4><b>No search results for the given keyword or tag.</b></h4>');
                    }
                }
            },
            error: function() {
                $('#preloader3').hide();
                $('#search_result').html('<h4><b>Error fetching search results.</b></h4>');
            }
        });
    }

    $(document).ready(function() {
        load_search();
    });
</script>

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
</script>

