<?php
  function calculate_total($price, $quantity) {
    $cost  = $price * $quantity;
    $tax   = $cost / 5;
    $total = $cost + $tax;
    return $total;
  }
?>
<!doctype html>
<html>
<head>
  <title>The Candy Store</title>
  <link rel="stylesheet" href="css/styles.css" />
</head>
<body>
    <h1>The Candy Store</h1>
  <p>Mints:  $<?php echo calculate_total(2, 5); ?></p>
<p>Toffee: $<?php echo calculate_total(3, 5); ?></p>
<p>Fudge:  $<?php echo calculate_total(5, 4); ?></p>
</body>
</html>