<!DOCTYPE html>
<html>
  <head><title>Calculator</title></head>
  <body>
  <?php
    if (isset($_POST['submit'])) {
      $width = $_POST['width'];
      $height = $_POST['height'];
      $area = $width * $height;
      $tins = ceil($area / 5);
      ?>
        <h1>Tins of paint needed</h1>
        <p><?php echo $tins ?></p>
      <?php
    } else {
  ?>
    <form action="post-to-same-page.php" method="post">
      <input type="number" name="width">
      <input type="number" name="height">
      <input type="submit" name="submit">
    </form>
  <?php
    }
  ?>
  </body>
</html>