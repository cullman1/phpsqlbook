<?php
function calculate_prices($us_price) {
  $uk_price = $us_price * .81;
  $eu_price = $us_price * .93;
  $price['us']  = $us_price;
  $price['uk'] = $uk_price;
  $price['eu'] = $eu_price;
  return $price;
}
$price = calculate_prices(4);
?>

<h1>The Candy Store - International Prices</h1>
<p>Chocolates</p>
<p> US Price $<?php echo $price['us']; ?></p>
<p> UK Price &pound;<?php echo $price['uk']; ?></p>
<p> EU Price &euro;<?php echo $price['eu']; ?></p>