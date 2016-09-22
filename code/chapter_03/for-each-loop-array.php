<?php
// Category names
$categories = array('herbs', 'vegetables', 'salad');
foreach ($categories as $value) {
echo $value . ' ';
}
// Seeds and prices
$stock = array(
'Chives' => 2.99,
'Basil' => 1.99,
'Mint' => 3.49);
foreach ($stock as $seed => $price) {
echo $seed . ' $' . $price . '<br>';
}
?>