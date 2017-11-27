<?php 
  $item    = 'Chocolate';
  $stock   = 5;
  $wanted  = 8;
  $can_buy = ($wanted < $stock);
?>
<!DOCTYPE html>
<html>
<head>
  <title>Variables</title>
  <link rel="stylesheet" href="css/styles.css" />
</head>
<body>
  <h1>The Candy Store</h1>
  <h2>Shopping Cart</h2>
  <p>Item:    <?php echo $item; ?></p>
  <p>Stock:   <?php echo $stock; ?></p>
  <p>Ordered: <?php echo $wanted; ?></p>
  <p>Can buy: <?php echo $can_buy; ?></p>
</body>
</html>