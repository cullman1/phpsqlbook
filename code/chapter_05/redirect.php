<?php 
  $now     = new DateTime();
  $expires = new DateTime('2017-03-30 23:59');
  if ($expires < $now) {
    header('Location: expired.php'); 
  }
?>
<!DOCTYPE html>
<html>
<head>
  <title>Built-in functions, objects and arrays</title>
  <link rel="stylesheet" href="css/styles.css" />
</head>
<body>
<h1>Discount code:</h1>
<p>Your discount code for 017-31-03</p>
</body>
</html>