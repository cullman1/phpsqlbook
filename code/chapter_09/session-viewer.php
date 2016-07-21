<?php
session_start();
$name = $_SESSION["name"] ? $_SESSION["name"] : "" ;
$color = $_SESSION["color"] ? $_SESSION["color"] : "" ;
if (isset($color)) {
       include("style.php");
 }
?>
<div>
 <?php if (!isset($name)) { ?>
  <a href="session-set.php">Preferences</a> 
 <?php } else { ?>
  <a href="session-set.php"><?php echo $name; ?></a> 
 <?php }  ?>
</div>
<div>Welcome to the home page</div>