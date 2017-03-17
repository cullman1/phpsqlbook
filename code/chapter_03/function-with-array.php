<?php
$us_price = 4;

$rates = array('uk'=>0.81, 
               'eu'=>0.93, 
               'jp'=>113.21);

function calculate_prices($us_price,$rates) {
  $price =  array('us' => $us_price,
                  'uk'=> $us_price * $rates['uk'],
                  'eu' => $us_price * $rates['eu'],
                  'jp' => $us_price * $rates['jp']);
  return $price;
}
$price = calculate_prices($us_price, $rates);
?>
<h1>The Candy Store</h1>
<p>Chocolates</p>
<p> US Price $<?php echo $us_price; ?></p>
<p>(UK Price &pound;<?php echo $price['uk']; ?> |
EU Price &euro;<?php echo $price['eu']; ?> |
JP Price &yen;<?php echo $price['jp']; ?>)</p>