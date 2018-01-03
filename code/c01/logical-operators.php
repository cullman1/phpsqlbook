<?php 
  $item    = 'Chocolate';
  $stock   = 5;
  $wanted  = 3;
  $deliver = true;
  $can_buy = (($wanted < $stock) && ($deliver == TRUE));
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Logical Operators</title>
    <link rel="stylesheet" href="css/styles.css" />
  </head>
  <body>
    <h1>The Candy Store</h1>
    <h1>Shopping Cart</h1>
    <p>Item:    <?php echo $item; ?></p>
    <p>Stock:   <?php echo $stock; ?></p>
    <p>Ordered: <?php echo $wanted; ?></p>
    <p>Can buy: <?php echo $can_buy; ?></p>
  </body>
</html>