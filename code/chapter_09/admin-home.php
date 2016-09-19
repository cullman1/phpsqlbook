<?php 
session_start();

function is_logged_in() {
  if (isset($_SESSION["forename"])) {
    return true;
  } else {
    return false;
  }
}

if (!is_logged_in()) {             
    header('Location:../admin/login.php');   
}
?>
<div class="horizontal-left">
  <a href="login-home.php">Home</a> | 
  <a href="login-about.php">About</a> | 
  <a href="login-services.php">Services</a>
</div>
<div>
  <?php if (!is_logged_in()) { ?>
    <a href="login.php">Login</a> 
  <?php } else { ?>
    <a href="prefer.php">
      <?= $_SESSION["forename"]; ?> 
    </a> 
    <img src="<?= $_SESSION['image']; ?>" />
  <?php }  ?>
</div>
<div class='menu'></div>
<hr/>
<div>Welcome to the home page!</div>