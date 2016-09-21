<?php
$stock = 5;
$wanted = 8;
$can_buy = ($wanted < $stock);
$backorder = true;
?>
<!DOCTYPE html>
<html>
<head>...</head>
<body>
<h1>Beet</h1>
<?php
if ($can_buy == true) {
echo '<a href="buy.php">buy now</a>';
} elseif ($backorder == true) {
echo '<a href="buy.php">buy now</a>';
echo '<br>Your order may take 3-4 days to ship';
} else {
echo 'More stock coming soon...';
}
?>
</body>
</html>