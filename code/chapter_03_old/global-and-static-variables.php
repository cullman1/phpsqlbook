<?php
$tax = 20;
$item_tax = 0;

 function total_items($price, $quantity) {
  global $tax;
  static $running_total;
  $cost  = $price * $quantity;
  $running_total = $running_total + $total;
  return $running_total;
 }

 
?>
<h1>The Candy Store</h1>
<table>
  <tr>
    <th>Item</th><th>Price</th><th>Qty</th><th>Running total</th>
  <tr>
  <tr><td>Mints:</td><td>2</td><td>5</td> 
      <td>$<?php echo total_items(2, 5); ?></td>
  <tr><td>Toffee:</td><td>3</td><td>5</td> 
      <td>$<?php echo total_items(3, 5); ?></td>
  <tr><td>Fudge:</td><td>5</td><td>4</td> 
      <td>$<?php echo total_items(5, 4); ?></td>
</table>
