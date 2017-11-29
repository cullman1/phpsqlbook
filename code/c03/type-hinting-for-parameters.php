<?php
$us_price = 4;

$rates = array('uk' => 0.81,
               'eu' => 0.93,
               'jp' => 113.21);

function calculate_prices(int $us_price, array $rates) {
  $prices =  array('uk' => $us_price * $rates['uk'],
                   'eu' => $us_price * $rates['eu'],
                   'jp' => $us_price * $rates['jp']);
  return $prices;
}

$intl_prices = calculate_prices($us_price, $rates);
?>
<!DOCTYPE html>
<html> 
<head>
  <title>Variables</title>
  <link rel="stylesheet" href="css/styles.css" />
</head>
  <body>
<h1>The Candy Store</h1>
<h2>Chocolates</h2>
<p>US $<?php echo $us_price; ?></p>
<p>(UK &pound; <?php echo $intl_prices['uk']; ?> | 
    EU &euro;  <?php echo $intl_prices['eu']; ?> | 
    JP &yen;   <?php echo $intl_prices['jp']; ?>)</p>
</body>
</html>