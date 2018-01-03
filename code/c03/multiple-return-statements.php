<?php
$stock = 25;

function get_stock_indicator($quantity) {
  if ($quantity >= 10) {
    return 'Good availability';
  }
  if ($quantity > 0 && $quantity < 10) {
    return 'Low stock';
  }
  return 'Out of stock';
}
?>
<!DOCTYPE html>
<html> 
  <head>
    <title>Multiple return statements</title>
    <link rel="stylesheet" href="css/styles.css" />
  </head>
  <body>
    <h1>The Candy Store</h1>
    <h2>Chocolates</h2>
    <p><?php echo get_stock_indicator($stock); ?></p>
    <p><?php
    if ($stock > 0) {
      echo '<a href="buy.php" class="button">buy</a>';
    } else {
      echo 'Out of stock';
    }
   ?></p>
  </body>
</html>