<?php

define('TAX', 20);

$basil   = Array('name' => 'basil', 'price' => 3, 'stock' => 12);
$chives  = Array('name' => 'chives', 'price' => 2, 'stock' => 26);
$parsley = Array('name' => 'parsley', 'price' => 4, 'stock' => 8);

$seeds = array($basil, $chives, $parsley);

function get_stock_value($price, $quantity) {
  return $price * $quantity;
}

function get_tax($price, $tax_rate) {
  return ($price / 100) * $tax_rate;
}

?>
<table>
<tr>
<th>Product</th>
<th>Cost</th>
<th>Stock</th>
<th>Total value</th>
<th>Tax due</th>
</tr>
<?php
foreach ($seeds as $seed) {
echo '<tr>';
foreach ($seed as $key => $value) {
echo '<td>' . $value . '</td>';
}
echo '<td>$' . get_stock_value($seed['price'], $seed['stock']) . '</td>';
echo '<td>$' . get_tax($seed['price'], TAX) . '</td>';
echo '</tr>';
}
?>
</table>