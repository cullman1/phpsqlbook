<h1>Small orders</h1>
<?php
for ($i = 1; $i < 10; $i++) {
echo $i . ' $' . $i * 1.99 . '<br>';
}
?>
<h1>Discounts for larger orders</h1>
<?php
for ($i = 10; $i < 100; $i = $i + 10) {
$order = $i * 1.99;
$discount = ($order / 10);
echo $i . ' packs $' . ($order - $discount) .
'<br>';
}
?>