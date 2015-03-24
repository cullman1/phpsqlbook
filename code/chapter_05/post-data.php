<!DOCTYPE html>
<?php
  $width = $_POST['width'];
  $height = $_POST['height'];
  $area = $width * $height;
  $tins = ceil($area / 5);
?>
<html>
  <head><title>Calculator</title></head>
  <body>
    <h1>Tins of paint needed</h1>
    <p><?php echo $tins ?></p>
  </body>
</html>