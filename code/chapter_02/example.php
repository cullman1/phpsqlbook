<?php
  define('STORE_NAME', 'The Candy Store');             // Constant to hold store name
  $username = 'Ivy';                                   // Variable to hold username
  if ($username == '') {                               // If username is blank
    $greeting = 'Welcome';                             // Set greeting to say 'Welcome' 
  } else {                                             // Otherwise
    $greeting = 'Hello, ' . $username . '.';           // Greeting is 'Hello' + username
  }

  $cart = array(                                       // Create array to holding order
    'item'  => 'Chocolate',                            // Item in cart
    'qty'   => 3,                                      // Quantity
    'price' => 5                                       // Price
  );
?>
<!DOCTYPE html>
<html>
  <head>
    <title><?php echo STORE_NAME; ?> Cart</title>              <!-- Show store name -->
    <link rel="stylesheet" href="css/styles.css" />
  </head>
  <body>
    <h1><?php echo STORE_NAME; ?> Shopping Basket</h1>         <!-- Show store name -->
    <p><?php echo $greeting; ?> Your cart contains:</p>        <!-- Show greeting -->
    <table>
      <tr>
        <th>Qty</th><th>Item</th><th>Price</th><th>Subtotal</th>
      </tr>
      <tr>
        <td><?php  echo $cart['qty']; ?></td>                  <!-- Show quantity -->
        <td><?php  echo $cart['item']; ?></td>                 <!-- Show item name -->
        <td>$<?php echo $cart['price']; ?></td>                <!-- Show price -->
        <td>$<?php echo $cart['qty'] * $cart['price']; ?></td> <!-- Show total -->
      </tr>
    </table>
  </body>
</html>