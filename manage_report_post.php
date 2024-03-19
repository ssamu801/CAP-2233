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

<div class="container-fluid">
    <form action="" id="manage-report-post">
		<input type="hidden" name="post_id" value="<?php echo isset($_GET['id']) ? $_GET['id']:'' ?>" class="form-control">
		<input type="hidden" name="user_id" value="<?php echo $_SESSION['login_id'] ?>" class="form-control">
        <div class="row form-group">
		    <div class="col-md-8">
			    <label class="control-label">What is the issue present in this post?</label> 
		    </div>
        </div>
  
		<input type="radio" id="choice1" name="choice" value="Hate Speech" onclick="hideTextarea()">
        <label for="choice1">Hate Speech</label><br>
  
        <input type="radio" id="choice2" name="choice" value="Violence" onclick="hideTextarea()">
        <label for="choice2">Violence</label><br>
  
        <input type="radio" id="choice3" name="choice" value="Harrassment" onclick="hideTextarea()">
        <label for="choice3">Harrassment</label><br>

        <input type="radio" id="choice4" name="choice" value="Misleading Information" onclick="hideTextarea()">
        <label for="choice4">Misleading Information</label><br>

		<input type="radio" id="choice5" name="choice" value="Other" onclick="showTextarea()">
        <label for="choice5">Other</label><br>

		<div class="row form-group" id="textarea-div" style="display: none;">
			<div class="col-md-12">
				<label for="textarea">Please specify the issue:</label><br>
				<textarea  maxlength="250" name="issue" style="width: 100%;" oninput="autoExpand(this)"></textarea>
                <div id="counter-wrapper" style="text-align: right;">
                    <span id="counter">0</span>
                    <span>/ 250</span>
                </div>
			</div>
		</div>


    </form>
</div>

<script>

	function showTextarea() {
        var textareaDiv = document.getElementById("textarea-div");
        textareaDiv.style.display = "block";
    }

	function autoExpand(textarea) {
    	textarea.style.height = 'auto';
    	textarea.style.height = (textarea.scrollHeight) + 'px';
		
		var counter = document.getElementById("counter");
    	counter.innerHTML = textarea.value.length;
	}

	function hideTextarea() {
        var textareaDiv = document.getElementById("textarea-div");
        textareaDiv.style.display = "none";
    }

	$('#manage-report-post').submit(function(e){
		e.preventDefault()

        if ($('input[name="choice"]:checked').length === 0) {
                alert('Please select an option.');
                return;
        }

		/*
		var formData = $(this).serializeArray();
    	console.log("Form Data:", formData);

    	var selectedChoice = $('input[name="choice"]:checked').val();
    	console.log("Selected Choice:", selectedChoice);

		return;
		*/
		
		start_load()
		$.ajax({
			url:'ajax.php?action=save_report_post',
			method:'POST',
			data:$(this).serialize(),
			success:function(resp){
				if(resp == 1){
					alert_toast("Report Submitted.",'success')
					setTimeout(function(){
						location.reload()
					},1000)
				}
			}
		}) 
		
	})
</script>
