<?php 
  // session_start();
  include_once "social_interaction/chat/php/config.php";

?>
<?php include_once "header.php"; ?>
<body>
  <div class="wrapper">
    <section class="users">
      <header>
        <div class="content">
          <?php 
            $id = $_SESSION['login_id'];
            $sql = mysqli_query($conn, "SELECT * FROM users WHERE id = $id");
            if(mysqli_num_rows($sql) > 0){
              $row = mysqli_fetch_assoc($sql);
            }
          ?>
          
          <div class="details">
            <span><?php echo $row['name'] ?></span>
            <p><?php echo $_SESSION['login_id'] ?></p>
          </div>
        </div>
      </header>
      <div class="search">
        <span class="text">Select a user to chat!</span>
        <input type="text" placeholder="Enter name to search...">
        <button><i class="fas fa-search"></i></button>
      </div>
      <div class="users-list">
  
      </div>
    </section>
  </div>

  <script src="social_interaction/chat/javascript/users.js"></script>

</body>
</html>
