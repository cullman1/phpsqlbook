<?php 
  $cost     = 5;
  $stock    = 25;
  $quantity = 3;

  require_once '/includes/functions.php';
  include '/includes/header.php';
?>
<!doctype html>
<html>
<head>
  <title>The Candy Store</title>
  <link rel="stylesheet" href="css/styles.css" />
</head>
<body>
  <h2>Chocolate</h2>
  (<?php echo get_stock_indicator($stock); ?>)
  <br>
  Total cost: 
  <?php echo calculate_cost($cost, $quantity); ?><br>
  <?php
    include('includes/footer.php');
  ?>
</body>
</html>