<?php
function calculate_cost($cost, $quantity, $discount = 0) {
  $cost = $cost * $quantity;
  return $cost - $discount;
}
?>
<!DOCTYPE html>
<html> 
  <head>
    <title>Default values for parameters</title>
    <link rel="stylesheet" href="css/styles.css" />
  </head>
  <body>
    <h1>The Candy Store</h1>
    <h2>Chocolates</h2>
    <p><?php echo '$' . calculate_cost(5, 10, 5); ?></p>
    <p><?php echo '$' . calculate_cost(3, 4); ?></p>
    <p><?php echo '$' . calculate_cost(4, 15, 20); ?></p>
  </body>
</html>