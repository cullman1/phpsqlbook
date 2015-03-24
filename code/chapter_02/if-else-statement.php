<?php 
  $qtyInStock = 5;
  $qtyOrdered = 8;
  $canOrder = ($qtyOrdered < $qtyInStock);
?>
<!DOCTYPE html>
<html>
<head>...</head>
<body>
  <h1>Beet</h1>
  <?php 
    if ($canOrder == true) {
      echo '<a href="buy.php">buy now</a>';
    } else {
      echo 'More stock coming soon...';
    }
  ?>
</body>
</html>