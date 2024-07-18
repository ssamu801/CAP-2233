<?php include 'db_connect.php' ?>
<?php
error_reporting(E_ERROR | E_PARSE);
if(isset($_GET['id'])){
    $qry = $conn->query("SELECT * FROM articles where article_id= ".$_GET['id']);
    foreach($qry->fetch_array() as $k => $val){
        $$k=$val;
    }

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
                
                        <div class="rating-wrapper float-right mr-4" id="test" data-id="<?php echo $article_id ?>">
                            <div class="star-wrapper">
                                <i class="bi bi-star"></i> 
                                <i class="bi bi-star"></i> 
                                <i class="bi bi-star"></i> 
                                <i class="bi bi-star"></i> 
                                <i class="bi bi-star"></i> 
                                <span class="badge badge-default"> Average: <?php echo $average ?> / 5 (<?php echo $rating_query_rows ?> Reviews)</span>
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

    /*
    $("div.star-wrapper i").on("mouseover", function () {
    if ($(this).siblings("i.vote-recorded").length == 0) {
        $(this).prevAll().addBack().addClass("bi-star-fill").removeClass("bi-star");  
        $(this).nextAll().removeClass("bi-star-fill yellow").addClass("bi-star");
    }
});



    $("div.star-wrapper i").on("click", function () {
        let rating = $(this).prevAll().length + 1;
        let article_id = $(this).closest("div.rating-wrapper").data("id");
        var title = <?php echo json_encode($title); ?>; // Ensure title is properly encoded
        var login_id = '<?php echo $_SESSION['login_id']; ?>';
        var type = "Article";

    if ($(this).siblings("i.vote-recorded").length == 0) {

        $(this).prevAll().addBack().addClass("vote-recorded");
        $.post("ajax.php?action=save_user_rating", { article_id: article_id, 
                    user_rating: rating,
                    title: title,
                    login_id: login_id,
                    type: type})
            .done(function (resp) {
                if (resp == 1) {
                    alert_toast("Data successfully saved.", 'success');
                    setTimeout(function () {
                        location.reload();
                    }, 1000);
                }
            })
            .fail(function () {
                alert_toast("Error saving data.", 'error');
            });

    }
});
*/

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



    $('#manage-topic').submit(function(e){
		e.preventDefault()

		
		var title = $('input[name="title"]').val();
 		var link = $('textarea[name="link"]').val();
		var publisher = $('textarea[name="publisher"]').val();

		if (title === '' || link === '' || publisher === '') {
    		alert("Please fill out all fields");
    		return;
  		}
		
		start_load()
		$.ajax({
			url:'ajax.php?action=save_article',
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
</script>
