<?php 
  $item    = 'Chocolate';
  $stock   = 5;
  $wanted  = 8;
  $can_buy = ($wanted < $stock);
?>
<!DOCTYPE html>
<html>
<head>
  <title>Comparison operators</title>
  <link rel="stylesheet" href="css/styles.css" />
</head>
<body>
  <h1>Your Basket</h1>
  <p>Item:    <?php echo $item; ?></p>
  <p>Stock:   <?php echo $stock; ?></p>
  <p>Wanted: <?php echo $wanted; ?></p>
  <p>Can buy: <?php echo $can_buy; ?></p>
</body>
</html>