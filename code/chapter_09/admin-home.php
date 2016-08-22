<?php 
function is_logged_in() {
  session_start();
  if (isset($_SESSION["forename"])) {
    return true;
  } else {
    return false;
  }
}

if (!is_logged_in()) {             
    header('Location:login2.php');   
}
?><head>
<script src="https://use.typekit.net/goi2qmp.js"></script>
<script>try{Typekit.load({ async: true });}catch(e){}</script>
<title>Login</title>
<style>
.horizontal-left { padding: 10px;
                   float:left;}
.horizontal-right {padding-top: 3px; position:relative; left: 200px;
                   float-right;}
</style>
</head>
<div>
<div class="tk-proxima-nova horizontal-left">
  <a href="login-home.php"> Home</a> | 
  <a href="login-about.php">About</a> | 
  <a href="login-services.php">Services</a>
</div>
<div class="tk-proxima-nova horizontal-right">
  <?php if (!isset($_SESSION["forename"])) { ?>
    <a href="login.php">Login</a> 
  <?php } else { ?>
    <a href="prefer.php">
      <?= $_SESSION["forename"]; ?> 
    </a> 
    <img width=20 src="<?= $_SESSION['image']; ?>"  />
  <?php }  ?>
</div>
</div>
<div style="clear:both;"></div>
<hr/>
<div class="tk-proxima-nova horizontal-left">Welcome to the home page!</div>