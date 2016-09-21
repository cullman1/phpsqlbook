<?php 
  $greeting = 'Thank you';
  $name= 'Ivy';
  $message = $greeting . ' ' . $name;
?>
<!DOCTYPE html>
<html>
<head>
  <title>Order complete</title>
  <link rel="stylesheeet" href="css/styles.css" />
</head>
<body>
  <h1>Your Order</h1>
  <p><?php echo $message; ?></p>
</body>
</html>