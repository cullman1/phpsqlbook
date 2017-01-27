<?php 
session_start();
if (!isset($_SESSION["loggedin"])) {             
    header('Location: login.php'); 
}
?>
<div class="horizontal-left">
  <a href="login-home.php">Home</a> | 
  <a href="login-about.php">About</a> | 
  <a href="login-services.php">Services</a>
</div>
<div>
  <?php if (!isset($_SESSION["loggedin"])) { ?>
    <a href="login.php">Login</a> 
  <?php } else { ?>
    <a href="prefer.php">
      <?= $_SESSION['forename']; ?> 
    </a> 
    <img src="<?= $_SESSION['image']; ?>" />
    <a href="logout.php">Logout</a>
  <?php }  ?>
</div>
<div class='menu'></div><hr/>
<div>Welcome to the home page!</div>