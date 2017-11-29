<?php
  $tax = 20;

  function running_total($price, $quantity) {
    global $tax;
    static $combined_total;
    $total = ($price * $quantity) + 
             (($price * $quantity) / 100) * $tax;
    $combined_total = $combined_total + $total;
    return $combined_total;
  }
?>
<!DOCTYPE html>
<html> 
<head>
  <title>Variables</title>
  <link rel="stylesheet" href="css/styles.css" />
</head>
  <body>
<h1>The Candy Store</h1>
<table>
  <tr><th>Item</th><th>Price</th><th>Qty</th>
    <th>Running total</th></tr>
  <tr><td>Mints:</td><td>2</td><td>5</td> 
    <td>$<?php echo running_total(2, 5); ?></td></tr>
  <tr><td>Toffee:</td><td>3</td><td>5</td> 
    <td>$<?php echo running_total(3, 5); ?></td></tr>
  <tr><td>Fudge:</td><td>5</td><td>4</td> 
    <td>$<?php echo running_total(5, 4); ?></td></tr>
</table>
</body>
</html>