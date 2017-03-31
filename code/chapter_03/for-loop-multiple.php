<!DOCTYPE html>
<html>
<head>
  <title>The Candy Store</title>
  <link rel="stylesheet" href="css/styles.css" />
</head>
<body>
<h1>Discounts for large orders</h1>
<?php 
  for ($i = 10; $i < 100; $i = $i + 10) {
    $order = $i * 1.99;
    $discount = ($order / 10);
    echo $i . ' packs: ';
    echo '$' . ($order - $discount) . '<br>';
  }
?>
</body>
</html>