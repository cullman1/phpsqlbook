<?php 
  $qtyInStock = 5;
  $qtyOrdered = 2;
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
    }
  ?>
</body>
</html>