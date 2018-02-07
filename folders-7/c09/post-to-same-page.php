<!DOCTYPE html>
<html>
  <head><title>Calculator</title></head>
  <body>
  <?php
    if (isset($_POST['submit'])) {
      $width = $_POST['width'];
      $height = $_POST['height'];
      $area = $width * $height;
      ?>
        <h1>Area</h1>
        <p><?php echo $area; ?>ft<sup>2</sup></p>
      <?php
    } else {
  ?>
    <form action="post-to-same-page.php" method="post">
      Width <input type="number" name="width">ft<br>
      Height <input type="number" name="height">ft<br>
      <input type="submit" name="submit">
    </form>
  <?php
    }
  ?>
  </body>
</html>