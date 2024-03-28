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
  background: #007bff;
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
	<form action="" id="manage-topic">
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
				<label class="control-label">Publihser/Author</label>
				<input type="text" name="publisher" class="form-control">
			</div>
		</div>
		<input type="hidden" name="added_by" value="<?php echo $_SESSION['login_name']?>" class="form-control">
	</form>
</div>

<script>
	$('.select2').select2({
		placeholder:"Please select here",
		width:"100%"
	})
	$('.text-jqte').jqte();
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
