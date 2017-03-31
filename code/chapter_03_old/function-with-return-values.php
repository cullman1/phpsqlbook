<?php
function calculate_discount($full_price, $sale_price) {
$amount = $full_price - $sale_price;
$percent = ($amount / $full_price) * 100;
$discount['amount'] = $amount;
$discount['percent'] = $percent;
return $discount;
}
$discount = calculate_discount(4, 3);
?>
...
<h1>Tomato F1 Hybrid Seeds</h1>
<li>You save: $<?php echo $discount['amount']; ?></li>
<li> A saving of <?php echo $discount['percent']; ?>%</li>