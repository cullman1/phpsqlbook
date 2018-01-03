<!DOCTYPE html>
<html>
  <head>
    <title>for each Loop</title>
    <link rel="stylesheet" href="css/styles.css" />
  </head>
  <body>
    <h1>The Candy Store</h1>
    <h2>Order</h2>
    <?php
      // Candy and prices
      $order = array('Toffee' => 2.99,
                     'Mints' => 1.99,
                     'Fudge' => 3.49);

      // foreach loop using keys and values
      foreach ($order as $product => $price) {
        echo '<p>' . $product . ' $' . $price . '</p>';
      }
    ?>
  </body>
</html>