<?php
$cost = 5;
$items = 3;
$subtotal = $cost * $items;
$tax = ($subtotal / 100) * 20;
$total = $subtotal + $tax;
?>
<!DOCTYPE html>
<html>
<head>
<title>Mathematical operators</title>
<link rel="stylesheet" href="css/styles.css" />
</head>
<body>
<h1>Your Basket</h1>
<p>Items <?php echo $items; ?></p>
<p>Cost per pack $<?php echo $cost; ?></p>
<p>Subtotal $<?php echo $subtotal; ?></p>
<p>Tax $<?php echo $tax; ?></p>
<p>Total $<?php echo $total; ?></p>
</body>
</html>