<!DOCTYPE html>
<html>
<head>
  <title>The Candy Store</title>
  <link rel="stylesheet" href="css/styles.css" />
</head>
<body>
<h1>Best sellers</h1>
<?php
  // Category names  (or best sellers)
  $best_sellers = array('Toffee', 'Mints', 'Fudge');
  
  // foreach loop returning only values
  foreach ($best_sellers as $value) {
    echo $value . '<br>';
  }
?>
</body>
</html>