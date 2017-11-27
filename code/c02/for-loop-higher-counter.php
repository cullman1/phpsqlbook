<!DOCTYPE html>
<html>
<head>
  <title>Variables</title>
  <link rel="stylesheet" href="css/styles.css" />
</head>
<body>
  <h1>The Candy Store</h1>
 <h2>Discounts for large orders</h2>
<?php 
  for ($i = 10; $i < 100; $i = $i + 10) {
    $cost     = $i * 1.99;
    $discount = ($cost / 10);
    echo '<p>' . $i . ' packs: ';
    echo '$' . ($cost - $discount) . '</p>';
  }
?>
</body>
</html>