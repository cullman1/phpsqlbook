<head>
<script src="https://use.typekit.net/goi2qmp.js"></script>
<script>try{Typekit.load({ async: true });}catch(e){}</script>
<title></title>
</head>
<div  style="padding: 10px;float:left;">
    <a class="tk-proxima-nova" href="cookie-home.php">Home</a> | <a class="tk-proxima-nova" href="cookie-about.php">About</a> | <a class="tk-proxima-nova" href="cookie-services.php">Services</a>
</div>
<div class="tk-proxima-nova" style="padding: 10px; float:right;">
    <?php if ($username==null) { ?>
    <a class="tk-proxima-nova" href="cookie-preferences.php">Preferences</a> 
     <?php } else { ?>
    <a class="tk-proxima-nova" href="cookie-preferences.php"><?php echo $username; ?></a> 
    <?php }  ?>
</div>
<div style="clear:both;"></div>
<hr/>
