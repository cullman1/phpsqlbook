<?php 
  $item    = 'Chocolate';
  $stock   = 5;
  $wanted  = 3;
  $deliver = true;
  $can_buy = (($wanted < $stock) && ($deliver == true));
?>
<!DOCTYPE html>
<html>
<head>
  <title>Logical operators</title>
  <link rel="stylesheet" href="css/styles.css" />
</head>
<body>
  <h1>Your Basket</h1>
  <p>Item:    <?php echo $item; ?></p>
  <p>Stock:   <?php echo $stock; ?></p>
  <p>Wanted: <?php echo $wanted; ?></p>
  <p>Can buy: <?php echo $can_buy; ?></p>
</body>
</html>