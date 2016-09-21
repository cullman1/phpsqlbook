<?php
$stock = 5;
$wanted = 2;
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
}
?>
</body>
</html>