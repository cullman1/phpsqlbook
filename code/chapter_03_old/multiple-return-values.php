<?php
error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', TRUE);
$quantity = 25;

function get_stock_indicator($quantity) {
  if ($quantity >= 10) {
    return 'Good availability';
  }
  if ($quantity > 0 && $quantity < 10) {
    return 'Low stock';
  }
  if ($quantity < 1) {
    return 'Out of stock';
  }
}
?>
<h1>The Candy Store</h1>
<p>Chocolates</p>
<?php
echo get_stock_indicator($quantity);

if ($quantity > 0) {
  echo '<p><a href="buy.php">Buy now</a></p>';
} else {
  echo 'Out of stock';
}

?>