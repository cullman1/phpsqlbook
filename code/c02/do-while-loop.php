<!DOCTYPE html>
<html>
  <head>
    <title>do while Loop</title>
    <link rel="stylesheet" href="css/styles.css" />
  </head>
  <body>
    <h1>The Candy Store</h1>
    <h2>Discounts</h2>
    <?php 
      $i     = 6;
      $packs = 5;
      $price = 1.99;

      do {
        echo '<p>' . $i . ' packs = ' . $i * $price;
        echo ' <i>(' . $price . ' per packet)</i></p>';
        $price = $price - 0.05;
        $i++;
      } while ($i <= $packs);
    ?>
  </body>
</html>