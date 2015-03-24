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
    } else if ($backorder == true) {
     echo '<a href="buy.php">buy now</a>';
     echo 'Your order may take 3-4 days to ship';      
    } else {
      echo 'More stock coming soon...';
    }
  ?>
</body>
</html>