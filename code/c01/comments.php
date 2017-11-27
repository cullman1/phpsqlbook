<?php 
  /* 
  This page displays the user's name in a greeting
  and details of a current offer
  */
  $username = 'Ivy';  // Store user's name
?>
<!DOCTYPE html>
<html>
<head>
  <title>echo Command with double quotes</title>
  <link rel="stylesheet" href="css/styles.css" />
</head>
<body>
  <h1>The Candy Store</h1>
  <h2><?php echo "Welcome $username"; ?>.</h2>
  <?php echo "<p class=\"offer\">Offer: 20% off</p>" ?>
</body>
</html>