<?php
include('class_lib.php');
$tax_rate = 20;
$basil = new Seed('Basil', 3, 32);
$chives = new Seed('Chives', 4, 56);
$parsley = new Seed('Parsley', 3, 14);
$seeds = array($basil, $chives, $parsley);
function total($price, $quantity) {
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
echo '<td>$' . total($seed->price, $seed->stock) . '</td>';
echo '<td>$' . get_tax($seed->price, $tax_rate) . '</td>';
echo '</tr>';
}
?>
</table>