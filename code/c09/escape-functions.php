<?php
$markup   = '< > / & " \'';
$accents  = 'ä ê';
$currency = '£ ¥';
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Escape Functions</title>
    <meta http-equiv="Content-Type" 
     content="text/html; charset=utf-8" />
  </head>
<body>
<p>Your password should not contain the following:<br>
Markup   <?php echo htmlspecialchars($markup); ?><br>
Accents  <?php echo htmlentities($accents); ?><br>
Currency <?php echo htmlentities($currency); ?></p>
</body>
</html>