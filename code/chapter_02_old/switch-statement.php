<?php
$category = 'vegetables';
?>
<!DOCTYPE html>
<html>
<head>...</head>
<body>
<h1>Beet</h1>
<?php
switch ($category) {
case 'vegetables':
echo '<a href="veg.php">See more veg</a>';
break;
case 'fruit':
echo '<a href="fruit.php">See more fruit</a>';
break;
default:
echo '<a href="seeds.php">See more seeds</a>';
}
?>
</body>
</html>