<?php include 'db_connect.php' ?>
<?php
error_reporting(E_ERROR | E_PARSE);
if(isset($_GET['id'])){
    $art_id = $_GET['id'];
    $qry = $conn->query("SELECT * FROM articles where article_id= ".$_GET['id']);
    foreach($qry->fetch_array() as $k => $val){
        $$k=$val;
    }

    $chk = $conn->query("SELECT * FROM resources_views WHERE article_id={$_GET['id']} AND user_id='{$_SESSION['login_id']}' AND type='Article'")->num_rows;
    if($chk <= 0){
        $conn->query("INSERT INTO resources_views (article_id, user_id, type) VALUES ({$_GET['id']}, '{$_SESSION['login_id']}', 'Article')");
    }

    $sort_order = 'desc';
    $sort_order = isset($_GET['sort']) && $_GET['sort'] == 'newest' ? 'desc' : 'asc';

    $comments = $conn->query("SELECT c.*,u.name,u.username FROM article_comments c inner join users u on u.id = c.user_id where c.article_id= ".$_GET['id']." order by unix_timestamp(c.date_created) $sort_order");
    $com_arr= array();
    while($row= $comments->fetch_assoc()){
	    $com_arr[] = $row;
    }

    $view = $conn->query("SELECT * FROM resources_views where article_id={$_GET['id']} and type='Article' ")->num_rows;

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
    p {
        margin: unset;
    }
    #content {
        max-height: 60vh;
        overflow: auto;
    }
    #content pre {
        background: #80808091;
        padding: 5px;
    }
    div.star-wrapper i {
        cursor: pointer;
    }
    div.star-wrapper i.yellow {
        color: #FDD835;
    }
    div.star-wrapper i.done {
        cursor: auto;
    }
    div.star-wrapper i.vote-recorded {
        color: #F57C00;
    }
    p.v-data {
        background: #ccc;
        padding: 0.5rem;
    }
    .bi-star{
        color:#444444;
    }
    .toggle-switch {
        position: relative;
        display: inline-block;
        width: 3%; /* Reduced width */
        margin-top: -30px; /* Adjusted for smaller size */
    }

    input[type=checkbox] {
        height: 0;
        width: 0;
        visibility: hidden;
    }

    .toggle-label {
        cursor: pointer;
        width: 100%; 
        padding-top: 50%; 
        background: grey;
        display: block;
        border-radius: 100px;
        position: relative;
    }

    .toggle-label:after {
        content: '';
        position: absolute;
        top: 10%; /* Adjusted for smaller size */
        left: 10%; /* Adjusted for smaller size */
        width: 35%; /* Reduced size */
        height: 80%; /* Reduced size */
        background: #fff;
        border-radius: 90px;
        transition: 0.3s;
    }

    #switch:checked + label {
        background: #007bff;
    }

    #switch:checked + label:after {
        left: calc(100% - 10%); /* Adjusted for smaller size */
        transform: translateX(-100%);
    }

    .toggle-label:active:after {
        width: 55%; /* Adjusted for smaller size */
    }

    .toggle-wrap {
        display: flex;
        align-items: center;
    }

    #desc {
        margin-top: -20px; /* Adjusted for smaller size */
        margin-left: 10px;
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
                <span class="float-right mr-4"><small><i><?php echo date('M d, Y h:i A',strtotime($added_at)) ?></i></small></span>
                <span class="float-right mr-4 text-primary"><small><i>Publisher/Author: <?php echo ucwords($publisher) ?></i></small></span>
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
                <?php 
                    $user_id = $_SESSION['login_id'];
                    $rating_query = $conn->query("SELECT * from resources_ratings WHERE article_id = $article_id AND voter_id = $user_id AND type = 'Article'");
                    $average_query = $conn->query("SELECT COALESCE(AVG(user_rating), 0) AS average_rating FROM resources_ratings WHERE article_id = $article_id AND type = 'Article'");
                    $average_row = $average_query->fetch_assoc();
                    $average = number_format($average_row['average_rating'], 2);
                    $rating_query_rows = mysqli_num_rows($rating_query);
                    if($rating_query_rows == 0) {
                        ?>
                
                    <span class="badge badge-default float-right mr-4 mt-1"> Average: <?php echo $average ?> / 5 (<?php echo $rating_query_rows ?> Reviews)</span>
                        <div class="rating-wrapper float-right" id="test" data-id="<?php echo $article_id ?>">
                            <div class="star-wrapper">
                                <i class="bi bi-star"></i> 
                                <i class="bi bi-star"></i> 
                                <i class="bi bi-star"></i> 
                                <i class="bi bi-star"></i> 
                                <i class="bi bi-star"></i> 

                            </div>
                        </div>
                    <?php } else { ?>
                            <div class="rating-wrapper float-right mr-4" data-id="<?php echo $article_id ?>">
                                <div class="star-wrapper">
                        <?php
                                $rating_row = $rating_query->fetch_assoc();
                                $user_rating = $rating_row['user_rating'];
                                for($i = 1 ; $i <= 5 ; $i++){
                                   
                                    if($i <= $user_rating){
                                        echo '<i class="bi bi-star-fill yellow vote-recorded done"></i> ';
                                    }
                                    else{
                                        echo '<i class="bi bi-star done"></i> ';
                                    }
                                }
                        ?>
                                    <span class="badge badge-default"> Average: <?php echo $average ?> / 5 (<?php echo $rating_query_rows ?> Reviews)</span>
                                </div>
                            </div>
                    <?php }  ?>
     <!--           <div class="rating-wrapper float-right mr-4" data-id="<?php echo $article_id ?>">
                    <div class="star-wrapper">
                        <i class="bi bi-star"></i>
                        <i class="bi bi-star"></i>
                        <i class="bi bi-star"></i>
                        <i class="bi bi-star"></i>
                        <i class="bi bi-star"></i>
                    </div>  
                </div> -->
                <br>
                <hr>
                <div class="embed-responsive embed-responsive-16by9">
                    <iframe class="embed-responsive-item" src= <?php echo ($link) ?>></iframe>
                </div>
                <hr>
                <div class="w-100">
                    <!-- Additional content goes here -->
                </div>
                </div>
        </div>
        <div class="card">
			<div class="card-body">
    		<div class="col-lg-12">
    			<div class="row">
    				<h3><b> <i class="fa fa-comments"></i> Comment/s</b></h3>
    			</div>
                <label for="sort_comments" class="mr-2">Sort by:</label>
                        <select id="sort_comments" class="custom-select" style="width: auto;" onchange="sortComments()">
                            <option value="oldest" <?php echo ($sort_order == 'asc') ? 'selected' : ''; ?>>Oldest to Newest</option>
                            <option value="newest" <?php echo ($sort_order == 'desc') ? 'selected' : ''; ?>>Newest to Oldest</option>
                        </select>
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

                    <?php if($row['isAnonymous'] == 0): ?>
    				    <p class="mb-0"><large><b><?php echo $row['name'] ?></b></large>  <span class="text-primary"><small class="mb-0"><i><?php echo $row['username'] ?></i></small></span></p>
    				<?php else: ?>
                        <p class="mb-0"><large><b>Anonymous</b></large></p>
                    <?php endif; ?>    

    				<br>
    				<?php echo html_entity_decode($row['comment']) ?>
    				<div>

    				</div>
    				<hr>
    			</div>
    		<?php endforeach; ?>
    		</div>
    			<div class="col-lg-12">
    				<form action="" id="manage-article-comment">
    					<div class="form-group">
    						<input type="hidden" name="id" value="">
    						<input type="hidden" name="article_id" value="<?php echo $art_id?>">
    						<textarea class="form-control jqte" id="comment-txt" name="comment" cols="30" rows="5" placeholder="New Comment"></textarea>
    					</div>
                        <div class="toggle-wrap">
                            <div class="toggle-switch">
                                <input type="checkbox" id="switch" name="toggle_value" value=0/>
                                <label for="switch" class="toggle-label"></label>
                            </div>
                            <div id="desc">Comment anonymously</div>
                        </div> 
    					<button class="btn btn-primary float-right">Save Comment</button>
    				</form>
    			</div>
            </div>
        </div>
    </div>
</div>

<script>
    
	$('.jqte').jqte()
	$('.edit_topic').click(function(){
		uni_modal("Edit Topic","manage_topic.php?id="+$(this).attr('data-id'),'mid-large')
		
	})

    $("div.star-wrapper i").on("mouseover", function () {
        if ($(this).siblings("i.vote-recorded").length == 0) {
            $(this).prevAll().addBack().addClass("bi-star-fill yellow").removeClass("bi-star");  
            $(this).nextAll().removeClass("bi-star-fill yellow").addClass("bi-star");
        }
    });

    $("#test .star-wrapper i").on("click", function () {
        let rating = $(this).prevAll().length + 1;
        let article_id = $(this).closest("div.rating-wrapper").data("id");
        var title = <?php echo json_encode($title); ?>; // Ensure title is properly encoded
        var login_id = '<?php echo $_SESSION['login_id']; ?>';
        var type = "Article";
  
        if ($(this).siblings("i.vote-recorded").length == 0) {
    
            console.log(rating);
        console.log(article_id);
        console.log(title);
        console.log(login_id);
        console.log(type);
            
            $(this).prevAll().addBack().addClass("vote-recorded");
                $.post("index.php?page=information_resources/update_ratings", { article_id: article_id, user_rating: rating, title: title, login_id: login_id, type: type}).done(
                    setTimeout(function(){
						location.reload()
					},1000)
            );
    
        }
    });

    $('#manage-article-comment').submit(function(e){
		e.preventDefault()
		start_load()
		
        var content = $('textarea[name="comment"]').val();

        if (content.trim() === '') {
            alert("Please write a comment before submitting");
            location.reload(); // Reload the page after the alert
            return false;
        }
		$.ajax({
			url:'ajax.php?action=save_article_comment',
			method:'POST',
			data:$(this).serialize(),
			success:function(resp){
				if(resp == 1){
					alert_toast("Comment submitted.",'success')
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
            url:'ajax.php?action=delete_article_comment',
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

    $('.edit_comment').click(function(){
		uni_modal("Edit Comment","information_resources/manage_article_comment.php?id="+$(this).attr('data-id'),'mid-large')
		
	})

    function sortComments() {
        var sortOrder = document.getElementById('sort_comments').value;
        window.location.href = "<?php echo $_SERVER['PHP_SELF'] . '?page=information_resources/view_article&id=' . $_GET['id'] . '&sort='; ?>" + sortOrder;
    }
</script>