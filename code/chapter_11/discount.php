<h1>Discounts for larger orders</h1>
<p class="warning">This example demonstrates errors</p>
<?php 
ini_set("display_errors","1");
error_reporting(E_ERROR | E_WARNING | E_NOTICE);

function show_prices($products, $prices) {
    $count = 0;
    foreach ($products as $item) { 
        for ($i = 10; $i < 31; $i = $i + 10) {
            $order = $i * $prices[$count];
            $discount = ($order / 10);   
            echo $item . ' : '. $i . ' packs $' . 
            ($order - $discount) . '<br>';
        }
        $count++;
    } 
}

$products = array("peas","carrot","leek");
$price = array("1.25", "1.00",$_GET["price"]);
$prices =  show_prices($products, $price);
echo min($prices);

$products = array("lavender","chamomile","mint");
$price = array("3.50", "2.50","1.00");
$prices =  show_price($products, $price);
echo min($prices);
?>