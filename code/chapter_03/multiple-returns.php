<?php
$stock = 25;

function get_stock_indicator($stock) {
  if ($stock >= 10) {
    return 'Good availability';
  }
  if ($stock > 0 && $stock < 10) {
    return 'Low stock';
  }
  return 'Out of stock';
}
?>
<!doctype html>
<html>
<head>
  <title>The Candy Store</title>
  <link rel="stylesheet" href="css/styles.css" />
</head>
<body>
  <h1>The Candy Store</h1>
  <p>Chocolates</p>
  <p><?php echo get_stock_indicator($stock); ?></p>

  <?php if ($stock > 0) {
    echo '<p><a href="buy.php">Buy now</a></p>';
  } else {
    echo '<p>Out of stock</p>';
  }
  ?>
</body>
</html>