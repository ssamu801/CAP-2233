<?php 
	include('db_connect.php');
	$login_id = $_SESSION['login_id'];
?>
<style>
	.unfollow:hover{
		background-color: red;
		border-color: red;
	}
	.categories-list a{
		color:black;
	}
</style>
<div class="container-fluid">
<div class="row mb-4 mt-4">
			<div class="col-md-12">
				
			</div>
		</div>
	<div class="col-lg-12">
		<div class="row">
			<!-- FORM Panel -->
			<div class="col-md-4">
			<form action="" id="manage-category">
				<div class="card">
					<div class="card-header">
						    Category Form
				  	</div>
					<div class="card-body">
						<input type="hidden" name="login_id" value="<?php echo $login_id ?>">
						<input type="hidden" name="id">
						<div class="form-group">
							<label class="control-label">Name</label>
							<input type="text" class="form-control" name="name">
						</div>
					</div>
					<div class="card-body">
							<input type="hidden" name="id">
							<div class="form-group">
								<label class="control-label">Description</label>
								<textarea class="form-control" name="description" cols="30" rows="10"></textarea>
							</div>
					</div>
							
					<div class="card-footer">
						<div class="row">
							<div class="col-md-12">
								<button class="btn btn-sm btn-success col-sm-3 offset-md-3"> Save</button>
								<button class="btn btn-sm btn-default col-sm-3" type="button" onclick="$('#manage-category').get(0).reset()"> Cancel</button>
							</div>
						</div>
					</div>
				</div>
			</form>
			</div>
			<!-- FORM Panel -->

			<!-- Table Panel -->
			<div class="col-md-8">
				<div class="card">
					<div class="card-header">
						<b>Category List</b>
					</div>
					<div class="card-body">
						<table class="table table-bordered table-hover">
							<colgroup>
								<col width="5%">
								<col width="75%">
								<col width="20%">
							</colgroup>
							<thead>
								<tr>
									<th class="text-center">#</th>
									<th class="text-center">Information</th>
									<th class="text-center">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$i = 1;
								$category = $conn->query("SELECT * FROM categories order by name asc");
								while($row=$category->fetch_assoc()):
								?>
								<tr>
									<td class="text-center"><?php echo $i++ ?></td>
									<td class="categories-list">
										<a href="index.php?page=social_interaction/posts&id=<?php echo $row['id'] ?>">
										<p>Name: <b><?php echo $row['name'] ?></b></p>
										<p>Description</p>
										<p class="truncate"><?php echo $row['description'] ?></p>
										
									</td>
									<td class="text-center">
										<?php if($login_id == $row['created_by'] || $_SESSION['login_type'] == 4 ): ?>
											<button class="btn btn-sm btn-secondary edit_category" type="button" data-id="<?php echo $row['id'] ?>" data-name="<?php echo $row['name'] ?>" data-description="<?php echo $row['description'] ?>">Edit</button>
											<button class="btn btn-sm btn-danger delete_category" type="button" data-id="<?php echo $row['id'] ?>">Delete</button>
										<?php else: ?>
											<?php 
												$cat_id = $row['id'];
												$follow = $conn->query("SELECT * FROM categories_follow WHERE user_id=$login_id AND category_id=$cat_id");
												$total = mysqli_num_rows($follow);
												if($total > 0):
													
											?>
												<form action="" class="unfollow-category">
													<input type="hidden" name="login_id" value="<?php echo $login_id ?>">
													<input type="hidden" name="id" value="<?php echo $row['id'] ?>">
													<button class="btn btn-sm btn-success unfollow">Unfollow</button>
												</form>	
												<?php else: ?>
													<form action="" class="follow-category">
														<input type="hidden" name="login_id" value="<?php echo $login_id ?>">
														<input type="hidden" name="id" value="<?php echo $row['id'] ?>">
														<button class="btn btn-sm btn-success">Follow</button>
													</form>	
												<?php endif; ?>		
										<?php endif; ?>	
									</td>
								</tr>
								<?php endwhile; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<!-- Table Panel -->
		</div>
	</div>	

</div>
<style>
	
	td{
		vertical-align: middle !important;
	}
</style>
<script>
	
	$('#manage-category').submit(function(e){
		e.preventDefault()

		var name = $('[name="name"]').val();
  		var description = $('[name="description"]').val();

  		if(name == '' || description == ''){
    		alert("Please fill in all fields");
    		return;
  		}
		
		start_load()
		$.ajax({
			url:'ajax.php?action=save_category',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
				if(resp==1){
					alert_toast("Category successfully added",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
				else if(resp==2){
					alert_toast("Category successfully updated",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	})
	$('.edit_category').click(function(){
		start_load()
		var cat = $('#manage-category')
		cat.get(0).reset()
		cat.find("[name='id']").val($(this).attr('data-id'))
		cat.find("[name='name']").val($(this).attr('data-name'))
		cat.find("[name='description']").val($(this).attr('data-description'))
		end_load()
	})
	$('.delete_category').click(function(){
		_conf("Are you sure to delete this category?","delete_category",[$(this).attr('data-id')])
	})
	function delete_category($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_category',
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

	$('.follow-category').submit(function(e){
		e.preventDefault()
		
		start_load()
		$.ajax({
			url:'ajax.php?action=follow_category',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
				if(resp==1){
					alert_toast("Category added to Followed Categories",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
				
			}
		})
	})

	$('.unfollow-category').submit(function(e){
		e.preventDefault()
		
		start_load()
		$.ajax({
			url:'ajax.php?action=unfollow_category',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
				if(resp==1){
					alert_toast("Category removed from Followed Categories",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
				
			}
		})
	})

	$('table').dataTable()
</script>

<?php 
	/* 
		1-10
		27
		45
		90-113 follow and unfollow button
		157, 164 "Category"
	*/
?>