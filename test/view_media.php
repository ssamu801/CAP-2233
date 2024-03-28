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
   
        $video_id = getYouTubeVideoID($link);
        $youtube_embed_url = "https://www.youtube.com/embed/{$link}";
    }
    else{
        $qry = $conn->query("SELECT * FROM media_files where upload_id= ".$_GET['id']);
        foreach($qry->fetch_array() as $k => $val){
            $$k=$val;
        }
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
                    <span class="float-right mr-4"><small><i><?php echo date('M d, Y h:i A', strtotime($added_at)) ?></i></small></span>
                    <span class="float-right mr-4 text-primary"><small><i>Uploader: <?php echo $uploader ?></i></small></span>
                    <div class="col-md-8">
                        <h4><b><?php echo $title ?></b></h4>
                    </div>
                    <hr>
                <div class="embed-responsive embed-responsive-16by9">
                    <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/<?php echo $video_id ?>" allowfullscreen></iframe>
                </div>
                <?php endif; ?>
                <!-- Display images -->

                
                <?php if ($_GET['type'] == 'File' && !empty($id)): ?>
                    <span class="float-right mr-4"><small><i><?php echo date('M d, Y h:i A', strtotime($upload_date)) ?></i></small></span>
                    <span class="float-right mr-4 text-primary"><small><i>Uploader: <?php echo $uploaded_by ?></i></small></span>
                    <div class="col-md-8">
                        <h4><b><?php echo $title ?></b></h4>
                    </div>
                    <hr>
                    <?php
                    $image_qry = $conn->query("SELECT * FROM media_files WHERE upload_id = $upload_id");
                    while ($image_row = $image_qry->fetch_assoc()) {
                        echo '<img src="medias/' . $image_row['file_name'] . '" class="img-fluid mb-2" alt="Image">';
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
					alert_toast("Data successfully saved.",'success')
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
</script>
