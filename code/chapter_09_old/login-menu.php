<head>
<script src="https://use.typekit.net/goi2qmp.js"></script>
<script>try{Typekit.load({ async: true });}catch(e){}</script>
<title>Login</title>
<style>
.success {color:red;}
.error {color:red;}
label {display:block;padding-bottom:10px;}
.indent {padding-left:10px; padding-bottom:10px;}
</style>
</head>
<div  style="padding: 10px;float:left;">
    <a class="tk-proxima-nova" href="session-home.php">Home</a> | <a class="tk-proxima-nova" href="session-about.php">About</a> | <a class="tk-proxima-nova" href="session-services.php">Services</a>
</div>
<div class="tk-proxima-nova" style="padding: 10px; float:right;">
       <?php if (!isset($_SESSION["forename"])) { ?>
    <a class="tk-proxima-nova" href="login.php">Login</a> 
     <?php } else { ?>
    <a class="tk-proxima-nova" href="session-preferences.php"><?= $_SESSION["forename"]; ?></a> 
		<img src="<?= $_SESSION['image']; ?>"  />
        <?php }  ?>
</div>
<div style="clear:both;"></div>
<hr/>