<?php 
  $greeting = 'Thank you';
  $name     = 'Ivy';
  $message  = $greeting . ', ' . $name;
?>
<!DOCTYPE html>
<html>
  <head>
    <title>String Operator</title>
    <link rel="stylesheet" href="css/styles.css" />
  </head>
  <body>
    <h1>The Candy Store</h1>
    <h2><?php echo $name; ?>'s Order</h2>
    <p><?php echo $message; ?></p>
  </body>
</html>