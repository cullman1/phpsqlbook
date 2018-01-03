<?php 
  $time   = 14.48;
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Ternary Operator</title>
    <link rel="stylesheet" href="css/styles.css" />
  </head>
  <body>
    <h1>The Candy Store</h1>
    <p>Good  
    <?php 
      echo ($time < 12 ? 'morning!' : 'afternoon');
    ?>
    - we are 
    <?php 
      echo (($time > 9 && $time < 18) ? 'open' : 'closed');
    ?> 
    </p>
  </body>
</html>