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
  
        <input type="radio" id="choice1" name="choice" value="Hate Speech">
        <label for="choice1">Hate Speech</label><br>
  
        <input type="radio" id="choice2" name="choice" value="Violence">
        <label for="choice2">Violence</label><br>
  
        <input type="radio" id="choice3" name="choice" value="Harrassment">
        <label for="choice3">Harrassment</label><br>

        <input type="radio" id="choice4" name="choice" value="Misleading Information">
        <label for="choice4">Misleading Information</label><br>

    </form>
</div>

<script>

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
