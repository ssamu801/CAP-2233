<?php include '../db_connect.php' ?>
<?php
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
				<label class="control-label">Tags/Category</label>
				<select name="category_ids[]" id="category_ids" multiple="multiple" class="custom-select select2" >
					<option value=""></option>
				<?php
				$tag = $conn->query("SELECT * FROM categories order by name asc");
				while($row= $tag->fetch_assoc()):
				?>
					<option value="<?php echo $row['id'] ?>" <?php echo isset($category_ids) && in_array($row['id'], explode(",",$category_ids)) ? "selected" : '' ?>><?php echo $row['name'] ?></option>
			<?php endwhile; ?>
			</select>
			</div>
		</div>
		<div class="row form-group">
			<div class="col-md-12">
				<label class="control-label">Content</label>
				<textarea name="content" class="text-jqte"><?php echo isset($content) ? $content : '' ?></textarea>
			</div>
		</div>
		<?php if(!isset($isAnonymous)):?>
		<div class="toggle-wrap">
    		<div class="toggle-switch">
        		<input type="checkbox" id="switch" name="toggle_value" value=0/>
        		<label for="switch" class="toggle-label"></label>
    		</div>
    		<div id="desc">Post anonymously</div>
		</div>
		<?php endif; ?>  
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
 		var content = $('textarea[name="content"]').val();
  		var categoryIds = $('#category_ids').val();

		if (title === '' || content === '' || categoryIds == "") {
    		alert("Please fill out all fields");
    		return;
  		}
		
		start_load()
		$.ajax({
			url:'ajax.php?action=save_topic',
			method:'POST',
			data:$(this).serialize(),
			success:function(resp){
				if(resp == 1){
					alert_toast("Post edited.",'success')
					setTimeout(function(){
						location.reload()
					},1000)
				}
			}
		})
	})
</script>