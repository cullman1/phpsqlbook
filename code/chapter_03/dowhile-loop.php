<!DOCTYPE html>
<html>
<head>
  <title>The Candy Store</title>
  <link rel="stylesheet" href="css/styles.css" />
</head>
<body>
<h1>Discounts</h1>
<?php 
  $i           = 6;
  $max_packets = 5;
  $price       = 1.99;

  do {
    echo $i . ' packs = ' . $i * $price;
    echo ' <i>(' . $price . ' per packet)</i><br>';
    $price = $price - 0.05;
    $i++;
  } while ($i < $max_packets);
?>
</body>
</html>