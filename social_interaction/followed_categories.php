<?php 
    include('db_connect.php');
    $login_id = $_SESSION['login_id'];
?>
<style>
    .unfollow:hover{
        background-color: red;
        border-color: red;
    }
    .following a{
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
            <!-- Table Panel -->
            <div class="col-md-12">
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
                                $category = $conn->query("SELECT c.id, c.name, c.description, cf.user_id 
                                                          FROM categories c 
                                                          JOIN categories_follow cf ON c.id=cf.category_id
                                                          WHERE cf.user_id=$login_id 
                                                          ORDER BY name asc;");
                                if($category->num_rows > 0):
                                    while($row=$category->fetch_assoc()):
                                ?>
                                <tr>
                                    <td class="text-center"><?php echo $i++ ?></td>
                                    <td class="following">
                                        <a href="index.php?page=social_interaction/posts&id=<?php echo $row['id'] ?>">
                                            <p>Name: <b><?php echo $row['name'] ?></b></p>
                                            <p>Description</p>
                                            <p class="truncate"><?php echo $row['description'] ?></p>
                                        </a>
                                    </td>
                                    <td class="text-center">
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
                                    </td>
                                </tr>
                                <?php 
                                    endwhile;
                                else: 
                                ?>
                                <tr>
                                    <td colspan="3" class="text-center">You are not following any categories yet.</td>
                                </tr>
                                <?php endif; ?>
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
