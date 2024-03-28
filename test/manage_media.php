<?php include 'db_connect.php' ?>
<?php
session_start();
if(isset($_GET['id'])){
    $qry = $conn->query("SELECT * FROM topics where id=".$_GET['id'])->fetch_array();
    foreach($qry as $k =>$v){
        $$k = $v;
    }
}

?>
<style>
    /* */
    .toggle-switch {
      position: relative;
      display: inline-block;
      width: 6%;
      margin-top: -45px; 
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
      top: 5.5%;
      left: 5%;
      width: 45%; 
      height: 90%; 
      background: #fff;
      border-radius: 90px;
      transition: 0.3s;
    }

    #switch:checked + label {
      background: #107a32;
    }

    #switch:checked + label:after {
      left: calc(100% - 5%);
      transform: translateX(-100%);
    }

    .toggle-label:active:after {
      width: 65%;
    }

    .toggle-wrap {
      display: flex;
      align-items: center;
    }

    #desc {
        margin-top: -30px; 
      margin-left: 10px; 
    }
</style>

<div class="container-fluid">
      <br>
      <div class="toggle-wrap">
    		<div class="toggle-switch">
        		<input type="checkbox" id="switch" name="toggle_value" value=0/>
        		<label for="switch" class="toggle-label"></label>
    		</div>
    		<div id="desc">Add an Embed Video</div>
		</div>  
    <form action="" id="mediaForm">
        <input type="hidden" name="id" value="<?php echo isset($_GET['id']) ? $_GET['id']:'' ?>" class="form-control">
        
        <div class="row form-group">
            <div class="col-md-8">
                <label class="control-label">Title</label>
                <input type="text" name="mediaTitle" id="mediaTitle" class="form-control">
            </div>
        </div>
        <div class="row form-group">
			    <div class="col-md-8">
				    <label class="control-label">Uploader</label>
				    <input type="text" name="uploader" class="form-control">
			    </div>
		    </div>
        <div class="row form-group">
            <div class="col-md-8">
                <label class="control-label">Select Image(s)/Video:</label>
                <br>
                <input type="file" name="mediaFile[]" id="mediaFile" multiple accept="image/*">
            </div>
        </div>
        <input type="hidden" name="added_by" value="<?php echo $_SESSION['login_name']?>" class="form-control">
    </form>
    
    <form action="" id="manage-embed">
				<input type="hidden" name="id" value="<?php echo isset($_GET['id']) ? $_GET['id']:'' ?>" class="form-control">
				
		<div class="row form-group">
			<div class="col-md-8">
				<label class="control-label">Title</label>
				<input type="text" name="title" class="form-control" value="<?php echo isset($title) ? $title:'' ?>">
			</div>
		</div>
		<div class="row form-group">
			<div class="col-md-8">
				<label class="control-label">Link</label>
				<input type="text" name="link" class="form-control">
			</div>
		</div>
		<div class="row form-group">
			<div class="col-md-8">
				<label class="control-label">Uploader</label>
				<input type="text" name="uploader" class="form-control">
			</div>
		</div>
		<input type="hidden" name="added_by" value="<?php echo $_SESSION['login_name']?>" class="form-control">
	</form>
</div>

<script>
    $(document).ready(function(){
    // Hide the second form initially
    $('#manage-embed').hide();

    // Toggle form visibility based on checkbox state
    $('#switch').change(function(){
        if($(this).prop('checked')){
            $('#mediaForm').hide();
            $('#manage-embed').show();
        } else {
            $('#mediaForm').show();
            $('#manage-embed').hide();
        }
    });

    // Form submission for mediaForm
    $('#mediaForm').on('submit', function(e){
        e.preventDefault(); // Prevent default form submission behavior

        if($('#switch').prop('checked')){
            return;
        }

        // Validate title and files before submission
        var title = $('#mediaTitle').val();
        var files = $('#mediaFile').prop('files');

        if(title.trim() === ''){
            alert('Please enter a title.');
            return;
        }

        if(files.length === 0){
            alert('Please select at least one file.');
            return;
        }

        var formData = new FormData(this);
        $.ajax({
            url: 'ajax.php?action=save_media',
            type: 'POST',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function(response){
                console.log("Response from server:", response);
                if(response == 1){
                    alert_toast("Data successfully saved", 'success');
                    setTimeout(function(){
                        location.reload();
                    }, 1500);
                }
            }
        });
    });

    // Form submission for manage-embed
    $('#manage-embed').submit(function(e){
        e.preventDefault(); // Prevent default form submission behavior

        if(!$('#switch').prop('checked')){
            return;
        }

        var title = $('input[name="title"]').val();
        var link = $('textarea[name="link"]').val();
        var uploader = $('textarea[name="uploader"]').val();

        if (title === '' || link === '' || uploader === '') {
            alert("Please fill out all fields");
            return;
        }

        start_load();
        $.ajax({
            url: 'ajax.php?action=save_embed',
            method: 'POST',
            data: $(this).serialize(),
            success: function(resp){
                if(resp == 1){
                    alert_toast("Data successfully saved.", 'success');
                    setTimeout(function(){
                        location.reload();
                    }, 1000);
                }
            }
        });
    });
});

</script>

