<style>
	.logo {
    margin: auto;
    font-size: 20px;
    background: white;
    padding: 7px 11px;
    border-radius: 50% 50%;
    color: #000000b3;
}
</style>

<nav class="navbar navbar-light" style="background-color:#107a32;">
  <div class="container-fluid mt-2 mb-2">
  	<div class="col-lg-12">
  		<div class="col-md-1 float-left" style="display: flex;">
  		
  		</div>
      <div class="col-md-4 float-left text-white">
        <large><b>                <a href="/" class="d-flex text-white text-decoration-none">
                    <span class="fs-5">W<span class="d-none d-sm-inline">ASP</span></span>
                </a></b></large>
      </div>
      <div class="col-md-4 float-left">
        <form id="manage-search" class="hidden">
            <input type="text" placeholder="Search here" id="find" class="form-control" value="<?php echo isset($_GET['keyword'])? $_GET['keyword'] :'' ?>">
        </form>
      </div>
	  	<div class="float-right">
        <div class=" dropdown mr-4">
            <a href="#" class="text-white dropdown-toggle"  id="account_settings" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $_SESSION['login_name'] ?> </a>
              <div class="dropdown-menu" aria-labelledby="account_settings" style="left: -4em;">
                <a class="dropdown-item" href="index.php?page=user_management/profile" id="manage_my_account"><i class="fa fa-cog"></i> Profile</a>
                <a class="dropdown-item" href="ajax.php?action=logout"><i class="fa fa-power-off"></i> Logout</a>
              </div>
        </div>
      </div>
  </div>
  
</nav>

<script>
  $('#manage_my_account').click(function(){
    uni_modal("Manage Account","manage_user.php?id=<?php echo $_SESSION['login_id'] ?>&mtype=own")
  })
  $('#find').keypress(function(e){
    if(e.which == 13){
      $('#manage-search').submit()
    }
  })
  $('#manage-search').submit(function(e){
    e.preventDefault()
    location.href = "index.php?page=social_interaction/search&keyword="+$('#find').val()
  })
</script>