<?php 
  $items = 3;
  $cost= 5;
  $subtotal = $items * $cost;
  $tax = ($subtotal / 100) * 20;
  $total = $subtotal + $tax;
?>
<!DOCTYPE html>
<html>
<head>
  <title>Shopping basket</title>
  <link rel="stylesheeet" href="css/styles.css" />
</head>
<body>
  <h1>Your Basket</h1>
  <p>Items <?php echo $items; ?></p>
  <p>Cost per pack <?php echo $cost; ?></p>
  <p>Subtotal <?php echo $subtotal; ?></p>
  <p>Tax <?php echo $tax; ?></p>
  <p>Total <?php echo $total; ?></p>
</body>
</html>