<?php
function get_price($price, $tax = '20', $discount = 0) {
$tax_rate = 1 + ($tax / 100);
$total = $price * $tax_rate;
return $total - $discount;
}
echo '$' . get_price(100) . '<br>';
echo '$' . get_price(100, 15) . '<br>';
echo '$' . get_price(100, 15, 20) . '<br>';
?>