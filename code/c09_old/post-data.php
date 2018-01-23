<?php
  $width  = $_POST['width'];
  $height = $_POST['height'];
  $area   = $width * $height;
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Calculator</title>
    <link rel="stylesheet" href="css/styles/css">
  </head>
  <body>
    <h1>Area of wall</h1>
    <p><?php echo $area; ?>ft<sup>2</sup></p>
  </body>
</html>