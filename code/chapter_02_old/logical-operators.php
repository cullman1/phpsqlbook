<?php
$item = 'Beet';
$stock = 5;
$wanted = 3;
$deliver = true;
$can_buy = (($wanted < $stock) && ($deliver == true));
?>
<!DOCTYPE html>
<html>
<head>...</head>
<body>
<h1>Your Basket</h1>
<p>Item: <?php echo $item; ?></p>
<p>Stock: <?php echo $stock; ?></p>
<p>Ordered: <?php echo $wanted; ?></p>
<p>Can buy: <?php echo $can_buy; ?></p>
</body>
</html>