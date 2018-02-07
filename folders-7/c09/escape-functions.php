<?php
  $markup   = '< > / & " \'';
  $accents  = 'ä ê';
  $currency = '£ ¥';
?>
<!DOCTYPE html>
<html>
  <head> ...
    <meta charset="utf-8" /> 
  </head>
<body>
  <p>Your password should not contain the following:
  <br>Markup  <?= htmlspecialchars($markup); ?><br>
  Accents <?= htmlentities($accents, ENT_QUOTES, 
                           'UTF-8', TRUE ); ?><br>
  Currency <?= htmlentities($currency, ENT_QUOTES, 
                           'UTF-8', TRUE ); ?></p>
</body>
</html>