<?php
session_start();
session_set_cookie_params(30*60, '/', '', false, true);

$color = isset($_SESSION['color']) 
           ? $_SESSION['color'] : '';
$name  = isset($_SESSION['name']) 
           ? $_SESSION['name'] : '';
if ($color != '') {
 echo '<link href="' . $color . '.css" />';
}
?>
</head>
<body>
<div>
 <?php if ($name == '') { ?>
  <a href="session-set.php">Preferences</a> 
 <?php } else { ?>
  <a href="session-set.php"><?php echo $name; ?></a> 
 <?php }  ?>
</div>
<div>Welcome to the home page</div>