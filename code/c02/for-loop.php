<!DOCTYPE html>
<html>
  <head>
    <title>for Loop</title>
    <link rel="stylesheet" href="css/styles.css" />
  </head>
  <body>
    <h1>The Candy Store</h1>
    <h2>Price list</h2>
    <?php
      for ($i = 1; $i < 10; $i++) {
        echo '<p>'. $i . ' $' . $i * 1.99 . '</p>';
      }
    ?>
  </body>
</html>