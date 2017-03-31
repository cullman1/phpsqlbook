<!DOCTYPE html>
<html>
<head>
  <title>The Candy Store</title>
  <link rel="stylesheet" href="css/styles.css" />
</head>
<body>
<h1>Price list</h1>
<?php
  for ($i = 1; $i < 10; $i++) {
    echo $i . ' $' . $i * 1.99 . '<br>';
  }
?>
</body>
</html>