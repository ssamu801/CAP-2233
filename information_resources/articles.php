<?php 
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

// Determine sorting option
$sort_option = isset($_GET['sort']) ? $_GET['sort'] : 'rating';

// Fetch articles and their average ratings from the database
$articles_query = "
    SELECT 
        a.article_id, 
        a.title, 
        a.category_ids, 
        a.added_at, 
        COALESCE(AVG(r.user_rating), 0) AS avg_rating
    FROM articles a
    LEFT JOIN resources_ratings r ON a.article_id = r.article_id
    GROUP BY a.article_id, a.title, a.category_ids, a.added_at
";

// Modify query based on sorting option
if ($sort_option == 'alphabetical') {
    $articles_query .= " ORDER BY a.title ASC";
} else {
    $articles_query .= " ORDER BY avg_rating DESC, a.title ASC";
}

$articles_result = $conn->query($articles_query);

$articles = [];
if ($articles_result->num_rows > 0) {
    while ($row = $articles_result->fetch_assoc()) {
        $articles[] = $row;
    }
}

// Fetch tags
$tag = $conn->query("SELECT * FROM categories ORDER BY name ASC");
if (!$tag) {
    die("Error fetching categories: " . $conn->error);
}
while ($row = $tag->fetch_assoc()) {
    $tags[$row['id']] = $row['name'];
}

?>

<div class="container-fluid">
<style>
    input[type=checkbox] {
        /* Double-sized Checkboxes */
        -ms-transform: scale(1.5); /* IE */
        -moz-transform: scale(1.5); /* FF */
        -webkit-transform: scale(1.5); /* Safari and Chrome */
        -o-transform: scale(1.5); /* Opera */
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
                    <?php if ($_SESSION['login_type'] == 1 || $_SESSION['login_type'] == 2 || $_SESSION['login_type'] == 3): ?>
                        <span>
                            <button class="btn navbar-color text-white btn-sm" type="button" id="new_media">
                                <i class="fa fa-plus"></i> Add Article
                            </button>
                        </span>
                    <?php endif; ?>

                    <!-- Advanced Search button and Sorting options -->
                    <div class="form-inline">
                        <button type="button" class="btn btn-outline-success mr-2" id="advancedSearchBtn" data-toggle="modal" data-target="#exampleModalCenter">
                            <i class="fas fa-search"></i> Advanced Search
                        </button>

                        <!-- Sorting options -->
                        <select id="sortSelect" class="form-control">
                            <option value="rating" <?php if ($sort_option == 'rating') echo 'selected'; ?>>Highest Rated</option>
                            <option value="alphabetical" <?php if ($sort_option == 'alphabetical') echo 'selected'; ?>>Alphabetical</option>
                        </select>
                    </div>

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
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="card-body">
                    <ul class="w-100 list-group" id="topic-list">
                        <?php foreach ($articles as $article): ?>
                            <?php
                                $article_id = $article['article_id'];
								$view = $conn->query("SELECT * FROM resources_views where article_id=".$article_id." AND type='Article'")->num_rows;
                                $comments_query = $conn->query("SELECT * FROM article_comments WHERE article_id = $article_id");
                                $comments_count = $comments_query->num_rows;
                                $article_tags = [];
                                if (!empty($article['category_ids'])) {
                                    $category_ids = explode(',', $article['category_ids']);
                                    foreach ($category_ids as $cat_id) {
                                        if (isset($tags[$cat_id])) {
                                            $article_tags[] = $tags[$cat_id];
                                        }
                                    }
                                }
                            ?>
                            <li class="list-group-item mb-4">
                                <div>
                                    <?php if ($_SESSION['login_type'] == 1): ?>
                                        <div class="dropleft float-right mr-4">
                                            <a class="text-dark" href="javascript:void(0)" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <span class="fa fa-ellipsis-v"></span>
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item edit_topic" data-id="<?php echo $article_id ?>" href="javascript:void(0)">Edit</a>
                                                <a class="dropdown-item delete_topic" data-id="<?php echo $article_id ?>" href="javascript:void(0)">Delete</a>
                                            </div>
                                        </div>    
                                    <?php else: ?>    
                                        <div class="dropleft float-right mr-4">
                                            <a class="text-dark" href="javascript:void(0)" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <span class="fa fa-ellipsis-v"></span>
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item report_topic" data-id="<?php echo $article_id ?>" href="javascript:void(0)">Report Post</a>
                                            </div>
                                        </div>    
                                    <?php endif; ?>
                                    <span class="float-right mr-4"><small><i>Created: <?php echo date('M d, Y h:i A', strtotime($article['added_at'])) ?></i></small></span>
                                    <a href="index.php?page=information_resources/view_article&id=<?php echo $article_id ?>" class="filter-text"><?php echo htmlspecialchars($article['title']) ?></a>
                                </div>

                                <hr>
                                <span class="float-left badge badge-secondary text-white mr-2"><?php echo number_format($view) ?> view/s</span>       
                                <span class="float-left badge badge-primary text-white"><i class="fa fa-comments"></i> <?php echo number_format($comments_count) ?> comment/s </span>
                                <span class="float-right">
                                    <span class="badge badge-default"><i class="fa fa-tags"></i> Tags: </span>
                                    <?php foreach ($article_tags as $tag): ?>
                                        <span class="badge badge-info text-white"><?php echo htmlspecialchars($tag) ?></span>
                                    <?php endforeach; ?>
                                    <span class="badge badge-success">Rating: <?php echo number_format($article['avg_rating'], 2) ?></span>
                                </span>
                            </li>
                        <?php endforeach; ?>
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
        uni_modal("New Entry", "information_resources/manage_topic.php", 'mid-large');
    });

    $('.edit_topic').click(function(){
        uni_modal("Edit Topic", "information_resources/manage_topic.php?id=" + $(this).attr('data-id'), 'mid-large');
    });

    $('.delete_topic').click(function(){
        _conf("Are you sure to delete this topic?", "delete_topic", [$(this).attr('data-id')], 'mid-large');
    });

    $('.report_topic').click(function(){
        uni_modal("Report Post", "information_resources/manage_report_post.php?id=" + $(this).attr('data-id'), 'mid-large');
    });

    function delete_topic(id){
        start_load();
        $.ajax({
            url: 'ajax.php?action=delete_topic',
            method: 'POST',
            data: {id: id},
            success: function(resp){
                if(resp == 1){
                    alert_toast("Data successfully deleted", 'success');
                    setTimeout(function(){
                        location.reload();
                    }, 1500);
                }
            }
        });
    }

    // Handle sort option change
    $('#sortSelect').change(function(){
        var selectedSort = $(this).val();
        window.location.href = "index.php?page=information_resources/articles&sort=" + selectedSort;
    });
</script>