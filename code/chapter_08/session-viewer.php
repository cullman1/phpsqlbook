<?php
session_start();
$name = isset($_SESSION["name"]) ? $_SESSION["name"] : "" ;
$color = isset($_SESSION["color"]) ? $_SESSION["color"] : "" ;
if ($color!="") {
     echo "<style>body{background: " . $color . "}</style>";
 }
?>
<div>
 <?php if ($name=="") { ?>
  <a href="session-set.php">Preferences</a> 
 <?php } else { ?>
  <a href="session-set.php"><?php echo $name; ?></a> 
 <?php }  ?>
</div>
<div>Welcome to the home page</div>