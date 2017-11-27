<?php
  $username = 'Ivy';                                   // Variable to hold username

  $greeting = 'Hello, ' . $username . '.';             // Greeting is 'Hello' + username

  $cart = array(                                       // Create array to holding order
    'item'  => 'Chocolate',                            // Item in cart
    'qty'   => 3,                                      // Quantity
    'price' => 5                                       // Price
  );

  $total = $cart['qty'] * $cart['price'];
?>
<!DOCTYPE html>
<html>
  <head>
    <title>The Candy Store</title>
    <link rel="stylesheet" href="css/styles.css" />
  </head>
  <body>
    <h1>The Candy Store</h1>
    <h2>Shopping Cart</h2>
    <p><?php echo $greeting; ?> Your cart contains:</p>       <!-- Show greeting -->
    <table>
      <tr>
        <th>Qty</th><th>Item</th><th>Price</th><th>Subtotal</th>
      </tr>
      <tr>
        <td><?php  echo $cart['qty']; ?></td>                  <!-- Show quantity -->
        <td><?php  echo $cart['item']; ?></td>                 <!-- Show item name -->
        <td>$<?php echo $cart['price']; ?></td>                <!-- Show price -->
        <td>$<?php echo $total; ?></td>                        <!-- Show total -->
      </tr>
    </table>
  </body>
</html>