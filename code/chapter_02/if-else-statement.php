<?php
$stock = 5;
$wanted = 8;
$can_buy = ($wanted < $stock);
?>
<!DOCTYPE html>
<html>
<head>...</head>
<body>
<h1>Beet</h1>
<?php
if ($can_buy == true) {
echo '<a href="buy.php">buy now</a>';
} else {
echo 'More stock coming soon...';
}
?>
</body>
</html>