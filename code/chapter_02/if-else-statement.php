<?php 
  $stock   = 5;
  $wanted  = 8;
  $can_buy = ($wanted < $stock);
?>
<!DOCTYPE html>
<html>
<head>
  <title>The Candy Store</title>
  <link rel="stylesheet" href="css/styles.css" />
</head>
<body>
  <h1>Chocolate</h1>
  <?php 
    if ($can_buy == TRUE) {
      echo '<a href="buy.php">buy now</a>';
    } else {
      echo 'More stock coming soon...';
    }
  ?>
</body>
</html>