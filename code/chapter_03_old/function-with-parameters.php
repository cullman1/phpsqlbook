<?php
function write_discount($full_price, $sale_price) {
$decrease = $full_price - $sale_price;
$percent_discount = ($decrease / $full_price) * 100;
echo $percent_discount . '&#37; off';
}
?>
<li>Basil: $<?php echo write_discount(4, 2); ?></li>
<li>Sage: $<?php echo write_discount(4, 3); ?></li>
<li>Thyme: $<?php echo write_discount(5, 4); ?></li>