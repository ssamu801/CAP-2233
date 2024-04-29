<?php include '../db_connect.php' ?>

<div class="container-fluid">
    <form action="" id="decline_topic">
		<input type="hidden" name="post_id" value="<?php echo isset($_GET['id']) ? $_GET['id']:'' ?>" class="form-control">
		<input type="hidden" name="login_name" value="<?php echo $_SESSION['login_name'] ?>" class="form-control">
        <div class="row form-group">
		    <div class="col-md-8">
			    <label class="control-label">State the reason for disapproval</label> 
		    </div>
        </div>

		<div class="row form-group" id="textarea-div">
			<div class="col-md-12">
				<textarea name="reason" style="width: 100%;"></textarea>
			</div>
		</div>


    </form>
</div>

<script>
    $('#decline_topic').submit(function(e){
        e.preventDefault();

        var reasonText = $(this).find('textarea[name="reason"]').val();
        if (reasonText.trim() === '') {
            alert('Please enter a reason for disapproval.');
            return false; // Prevent form submission
        }

        start_load();
        $.ajax({
            url: 'ajax.php?action=decline_topic',
            method: 'POST',
            data: $(this).serialize(),
            success: function(resp){
                if (resp == 1) {
                    alert_toast("Post declined.", 'success');
                    setTimeout(function(){
                        window.location.href = 'index.php?page=social_interaction/post_approval';
                    }, 1000);
                }
            }
        });
    });
</script>

