<!DOCTYPE html>
<html>
<head>
  <title>Built-in functions, objects and arrays</title>
  <link rel="stylesheet" href="css/styles.css" />
</head>
<body>
<?php
  $price         = 3;
  $dollar_rate   = 1.2;
  $last_update   = new DateTime();

  function calculate_price($price) {
    $GLOBALS['last_update'] ->modify(date('Y-m-d'));
    return $price * $GLOBALS['dollar_rate'];
  } 

  sleep(3); // Pause execution of script for 3 seconds

  echo 'Updated price is: $';
  echo calculate_price($price);
  echo '<br>Last updated: '; 
  echo $last_update->format('D d M Y, g:i:s');
?>
</body>
</html>