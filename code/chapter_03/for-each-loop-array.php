<?php
// Category names
$categories = array('toffee', 'mints', 'fudge');
foreach ($categories as $value) {
echo $value . ' ';
}
// Candy and prices
$stock = array(
'English Toffee' => 2.99,
'Chewy Mint' => 1.99,
'Vanilla Fudge' => 3.49);
foreach ($stock as $candy => $price) {
echo '<br>' . $candy . ' $' . $price ;
}
?>