<!DOCTYPE html>
<html>
<head>
  <title>The Candy Store</title>
  <link rel="stylesheet" href="css/styles.css" />
</head>
<body>
<h1>Order</h1>
<?php
  // Candy and prices
  $order = array('Toffee' => 2.99,
                 'Mints' => 1.99,
                 'Fudge' => 3.49);

  // foreach loop using keys and values
  foreach ($order as $product => $price) {
    echo $product . ' $' . $price . '<br>';
  }
?>
</body>
</html>