<?php 
  $stock     = 5;
  $wanted    = 8;
  $can_buy   = ($wanted < $stock);
  $backorder = true;
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
    } else if ($backorder == true) {
      echo '<a href="buy.php">buy now</a>';
      echo '<br>Your order may take 3-4 days to ship';      
    } else {
      echo 'More stock coming soon...';
    }
  ?>
</body>
</html>