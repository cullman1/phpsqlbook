<?php
  $qtyOrdered = 7;
?>
<!DOCTYPE html>
<html>
<head>...</head>
<body>
  <h1>Beet</h1>
  <?php 
    switch ($qtyOrdered) {
      case 'admin':
        echo '<a href="edit.php">Edit this product</a>';
        break;
      case 'customer':
       echo '<a href="edit.php">Edit this product</a>';
        break;
      default:
        echo '<a href="buy.php">Buy now</a>';
    }
  ?>
</body>
</html>