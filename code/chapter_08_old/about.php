<?php 
include 'session-include.php'; 
$name = isset($_SESSION["name"]) ? $_SESSION["name"] : "" ; 
?>
<div>
    <a href="home.php">Home</a> | 
    <a href="about.php">About</a> | 
    <a href="services.php">Services</a>
</div>
<div>
  <?php if ($name==null) { ?>
    <a href="session-set.php">Preferences</a> 
  <?php } else { ?>
    <a href="session-set.php"><?php echo $name; ?></a> 
  <?php }  ?>
</div>
<div style="clear:both;"></div>
<div>Welcome to the about page</div>
<?php include 'recently-viewed.php' ?>