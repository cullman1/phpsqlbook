<?php 
  $stock   = 5;
  $wanted  = 8;
?>
<!DOCTYPE html>
<html>
  <head>
    <title>if else Statement</title>
    <link rel="stylesheet" href="css/styles.css" />
  </head>
  <body>
    <h1>The Candy Store</h1>
    <h2>Chocolate</h2>
    <p>
    <?php 
    if ($stock > $wanted) {
      echo '<a href="buy.php" class="button">buy</a>';
    } else {
      echo 'More stock coming soon...';
    }
    ?>
    </p>
  </body>
</html>