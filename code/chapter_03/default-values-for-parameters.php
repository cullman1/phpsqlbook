<?php
function calculate_cost($cost, $quantity, $discount = 0) {
  $cost = $cost * $quantity;
  return $cost - $discount;
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
  <p>Chocolates</p>
  <?php
    echo '$' . calculate_cost(5, 10, 5) . '<br>';
    echo '$' . calculate_cost(3, 4) . '<br>';
    echo '$' . calculate_cost(4, 15, 20) . '<br>';
  ?>
</body>
</html>