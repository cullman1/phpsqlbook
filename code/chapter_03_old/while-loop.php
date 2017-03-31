<h1>Discounts</h1>
<?php
$counter = 1;
$packets = 5;
$price = 1.99;
while ($counter <= $packets) {
echo $counter . ' packs = ' . $counter * $price;
echo ' <i>(' . $price . ' per packet)</i><br>';
$price = $price - 0.05;
$counter++;
}
?>