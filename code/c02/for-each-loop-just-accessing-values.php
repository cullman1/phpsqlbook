<!DOCTYPE html>
<html>
  <head>
    <title>for each Loop - just accessing values</title>
    <link rel="stylesheet" href="css/styles.css" />
  </head>
  <body>
    <h1>The Candy Store</h1>
    <h2>Best sellers</h2>
    <?php
      // Category names  (or best sellers)
      $best_sellers = array('Toffee', 'Mints', 'Fudge');
  
      // foreach loop returning only values
      foreach ($best_sellers as $product) {
        echo '<p>' . $product . '</p>';
      }
    ?>
  </body>
</html>