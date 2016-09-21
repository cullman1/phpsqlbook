<?php 
  $item = 'Beet';
  $qtyInStock = 5;
  $qtyOrdered = 8;
  $delivery = true;
  $order = ($qtyOrdered > $qtyInStock) && (delivery = true);
?>
<!DOCTYPE html>
<html>
<head>...</head>
<body>
  <h1>Your Basket</h1>
  <p>Item: <?php echo $item; ?></p>
  <p>Ordered: <?php echo $qtyOrdered; ?></p>
  <p>Stock level: <?php echo $qtyInStock; ?></p>
  <p>Can buy: <?php echo $order; ?></p>
</body>
</html>