<!DOCTYPE html>
<html>
<head>
  <title>Variables</title>
  <link rel="stylesheet" href="css/styles.css" />
</head>
<body>
  <h1>The Candy Store</h1>
  <h2>Discounts</h2>
<?php
  $counter = 1;
  $packs   = 5;
  $price   = 1.99;

  while ($counter <= $packs) {
    echo '<p>' . $counter . ' packs = '; 
    echo $counter * $price;
    echo ' <i>(' . $price . ' per packet)</i></p>';
    $price = $price - 0.05;
    $counter++;
  }
?>
</body>
</html>