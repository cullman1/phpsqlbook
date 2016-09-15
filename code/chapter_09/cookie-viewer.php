<?php
$name  = filter_input(INPUT_COOKIE, 'name');
$color = filter_input(INPUT_COOKIE, 'color');
if ($color!='') {
  include('../includes/style.php');
}
?>
<div>
 <?php if ($name==null) { ?>
  <a href='cookie-set.php'>Preferences</a> 
 <?php } else { ?>
  <a href='cookie-set.php'><?php echo $name; ?></a> 
 <?php }  ?>
</div>
<div>Welcome to the home page</div>