<?php 
  $item = 'Beet';
  $qtyInStock = 5;
  $qtyOrdered = 8;
  $order = ($qtyOrdered > $qtyInStock);
?>
<!DOCTYPE html>
<html>
<head>...</head>
<body>
  <h1>Your Basket</h1>
  <p>Item: <?php echo $item; ?></p>
  <p>Ordered: <?php echo $qtyOrdered; ?></p>
  <p>Stock level: <?php echo $qtyInStock; ?></p>
  <p>Can buy: <?php echo $available; ?></p>
</body>
</html>