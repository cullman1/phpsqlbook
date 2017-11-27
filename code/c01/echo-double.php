<?php 
  $username = 'Ivy';
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