<?php include 'db_connect.php' ?>
<?php
error_reporting(E_ERROR | E_PARSE);

$vid_id = '';

function getYouTubeVideoID($url)
{
    if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $url, $matches)) {
        return $matches[1]; // Return the extracted video ID
    } else {
        return ''; // Return empty string if video ID extraction fails
    }
}


if(isset($_GET['id'])){

    if($_GET['type'] === 'Video'){
        $qry = $conn->query("SELECT * FROM embed_videos where video_id= ".$_GET['id']);
        foreach($qry->fetch_array() as $k => $val){
            $$k=$val;
        }
   
        $vid_id = getYouTubeVideoID($link);
        $youtube_embed_url = "https://www.youtube.com/embed/{$link}";

        $chk = $conn->query("SELECT * FROM resources_views WHERE article_id={$_GET['id']} AND user_id='{$_SESSION['login_id']}' AND type='Video'")->num_rows;
        if($chk <= 0){
            $conn->query("INSERT INTO resources_views (article_id, user_id, type) VALUES ({$_GET['id']}, '{$_SESSION['login_id']}', 'Video')");
        }

        $view = $conn->query("SELECT * FROM resources_views where article_id={$_GET['id']} and type='Video' ")->num_rows;
    }
    else{
        $qry = $conn->query("SELECT * FROM media_files where upload_id= ".$_GET['id']);
        foreach($qry->fetch_array() as $k => $val){
            $$k=$val;
        }

        $chk = $conn->query("SELECT * FROM resources_views WHERE article_id={$_GET['id']} AND user_id='{$_SESSION['login_id']}' AND type='File'")->num_rows;
        if($chk <= 0){
            $conn->query("INSERT INTO resources_views (article_id, user_id, type) VALUES ({$_GET['id']}, '{$_SESSION['login_id']}', 'File')");
        }

        $view = $conn->query("SELECT * FROM resources_views where article_id={$_GET['id']} and type='Video' ")->num_rows;
    }
        
    }


    if(!empty($category_ids)){
        $tag = $conn->query("SELECT * FROM categories where id in ($category_ids) order by name asc");
        while($row= $tag->fetch_assoc()):
            $tags[$row['id']] = $row['name'];
        endwhile;
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
</style>
<div class="container-field">
    <div class="row mb-4 mt-4">
        <div class="col-md-12">
    
        </div>
    </div>
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <!-- Embed video -->
                <?php if ($_GET['type'] == 'Video' && !empty($link)): ?>
                    <span class="float-right mr-4"><small><i><?php echo date('M d, Y h:i A', strtotime($created_at)) ?></i></small></span>
                    <span class="float-right mr-4 text-primary"><small><i>Uploader: <?php echo $uploader ?></i></small></span>
                    <div class="col-md-8">
                        <h4><b><?php echo $title ?></b></h4>
                    </div>
                    <?php 
                    $user_id = $_SESSION['login_id'];
                    $rating_query = $conn->query("SELECT * from resources_ratings WHERE article_id = $video_id AND voter_id = $user_id AND type = 'Video'");
                    $average_query = $conn->query("SELECT COALESCE(AVG(user_rating), 0) AS average_rating FROM resources_ratings WHERE article_id = $video_id AND type = 'Video'");
                    $average_row = $average_query->fetch_assoc();
                    $average = number_format($average_row['average_rating'], 2);
                    $rating_query_rows = mysqli_num_rows($rating_query);
                    if($rating_query_rows == 0) {
                        ?>
                
                <span class="badge badge-default float-right mr-4 mt-1"> Average: <?php echo $average ?> / 5 (<?php echo $rating_query_rows ?> Reviews)</span>
                        <div class="rating-wrapper float-right" id="test" data-id="<?php echo $video_id ?>">
                            <div class="star-wrapper">
                                <i class="bi bi-star"></i> 
                                <i class="bi bi-star"></i> 
                                <i class="bi bi-star"></i> 
                                <i class="bi bi-star"></i> 
                                <i class="bi bi-star"></i> 
                                
                            </div>
                            
                        </div>
                    <?php } else { ?>
                            <div class="rating-wrapper float-right mr-3" data-id="<?php echo $video_id ?>">
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
                    <br>
                    <hr>
                <div class="embed-responsive embed-responsive-16by9">
                    <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/<?php echo $vid_id ?>" allowfullscreen></iframe>
                </div>
                
                <?php endif; ?>

                <!-- Display images -->

                
                <?php if ($_GET['type'] == 'File' && !empty($id)): ?>
                    <span class="float-right mr-4"><small><i><?php echo date('M d, Y h:i A', strtotime($upload_date)) ?></i></small></span>
                    <span class="float-right mr-4 text-primary"><small><i>Uploader: <?php echo $uploaded_by ?></i></small></span>
                    <div class="col-md-8">
                        <h4><b><?php echo $title ?></b></h4>
                    </div>
                    <?php 
                    $user_id = $_SESSION['login_id'];
                    $rating_query = $conn->query("SELECT * from resources_ratings WHERE article_id = $upload_id AND voter_id = $user_id AND type = 'File'");
                    $average_query = $conn->query("SELECT COALESCE(AVG(user_rating), 0) AS average_rating FROM resources_ratings WHERE article_id = $upload_id AND type = 'File'");
                    $average_row = $average_query->fetch_assoc();
                    $average = number_format($average_row['average_rating'], 2);
                    $rating_query_rows = mysqli_num_rows($rating_query);
                    if($rating_query_rows == 0) {
                        ?>
                
                    <span class="badge badge-default float-right mr-4 mt-1"> Average: <?php echo $average ?> / 5 (<?php echo $rating_query_rows ?> Reviews)</span>
                        <div class="rating-wrapper float-right" id="test" data-id="<?php echo $upload_id ?>">
                            <div class="star-wrapper">
                                <i class="bi bi-star"></i> 
                                <i class="bi bi-star"></i> 
                                <i class="bi bi-star"></i> 
                                <i class="bi bi-star"></i> 
                                <i class="bi bi-star"></i> 
                                
                            </div>
                        </div>
                    <?php } else { ?>
                            <div class="rating-wrapper float-right mr-3" data-id="<?php echo $upload_id ?>">
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
                    <br>
                    <hr>
                    <?php
                    $image_qry = $conn->query("SELECT * FROM media_files WHERE upload_id = $upload_id");
                    while ($image_row = $image_qry->fetch_assoc()) {
                        echo '<img src="information_resources/medias/' . $image_row['file_name'] . '" class="img-fluid mb-2" alt="Image">';
                    }
                    ?>
                <?php endif; ?>
                <!-- <img src="medias/e057d201-ddec-4a4d-acbf-a512f2aeb274.jpeg" alt="Image Description"> -->
                <hr>
                <div class="w-100">
                    <!-- Additional content goes here -->
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
	$('.edit_comment').click(function(){
		uni_modal("Edit Comment","manage_comment.php?id="+$(this).attr('data-id'),'mid-large')
		
	})
	$('.edit_reply').click(function(){
		uni_modal("Edit Reply","manage_reply.php?id="+$(this).attr('data-id'),'mid-large')
		
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


    $('.delete_topic').click(function(){
        _conf("Are you sure to delete this topic?","delete_topic",[$(this).attr('data-id')],'mid-large')
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
        var type = '<?php echo $_GET['type']; ?>';
  
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
</script>

<?php 
    /* 
        27-33
        40-46
        132-133
        191-192
    */
?>