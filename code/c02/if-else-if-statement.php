<?php 
  $stock  = 5;
  $wanted = 8;
  $due    = 3;
?>
<!DOCTYPE html>
<html>
<head>
  <title>Variables</title>
  <link rel="stylesheet" href="css/styles.css" />
</head>
<body>
  <h1>The Candy Store</h1>
  <h2>Chocolate</h2>
  <p>
<?php 
  if ($stock >= $wanted) {
    echo '<a href="buy.php" class="button">buy</a>';
  } else if (($due + $stock) >= $wanted) {
    echo '<a href="buy.php" class="button">buy</a>';
    echo ' Order may take 3-4 days to ship';
  } else {
    echo 'Sorry! Sold out.';
  }
  ?></p>
</body>
</html>