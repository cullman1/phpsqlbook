<?php
error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', TRUE);
define('store_name', 'The Seed Store'); // Constant to hold store name
$username = 'Ivy'; // Username
if ($username == '') { // If username is blank
$greeting = 'Welcome'; // Set greeting to say 'Welcome'
} else { // Otherwise
$greeting = 'Welcome back, ' . $username . '.'; // Greeing is 'Welcome back' + username
}
$cart = array( // Create array to holding order
'item' => 'Basil', // Item in cart
'qty' => 3, // Quantity
'price' => 4 // Price
);
?>
<!DOCTYPE html>
<html>
<head>
<title><?php echo store_name; ?> Quote</title> <!-- Show store name -->
<style href="css/styles.css"></style>
</head>
<body>
<h1><?php echo store_name; ?> Quote</h1> <!-- Show store name -->
<p><?php echo $greeting; ?> Here is your quotation.</p> <!-- Show greeting -->
<table>
<tr>
<th>Qty</th><th>Item</th><th>Price</th><th>Subtotal</th>
</tr>
<tr>
<td><?php echo $cart['qty']; ?></td> <!-- Show quantity -->
<td><?php echo $cart['item']; ?></td> <!-- Show item name -->
<td>$<?php echo $cart['price']; ?></td> <!-- Show price -->
<td>$<?php echo $cart['qty'] * $cart['price']; ?></td><!-- Show total -->
</tr>
</table>
</body>
</html>