<?php
  $tax = '20%';

  function calculate_total($price, $quantity) {
    $cost  = $price * $quantity;
    $tax   = ($cost / 100) * 20;
    $total = $cost + $tax;
    return $total;
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Global and local scope</title>
    <link rel="stylesheet" href="css/styles.css" />
  </head>
  <body>
    <h1>The Candy Store</h1>
    <p>Mints:  $<?php echo calculate_total(2, 5); ?></p>
    <p>Toffee: $<?php echo calculate_total(3, 5); ?></p>
    <p>Fudge:  $<?php echo calculate_total(5, 4); ?></p>
    <p>Prices include tax at: $<?php echo $tax; ?></p>
  </body>
</html>