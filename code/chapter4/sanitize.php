<?php
  if (isset($_POST['submit'])) {
    $name  = filter_var($_POST['name'], FILTER_SANITIZE_SPECIAL_CHARS);
    $tel   = filter_var($_POST['tel'], FILTER_SANITIZE_NUMBER_INT);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $url   = filter_var($_POST['url'], FILTER_SANITIZE_URL);
  }
?>
<!DOCTYPE html>
<html>
  <head><title>Sanitize</title></head>
  <body>

    <form action="sanitize.php" method="post">
      <label for="name">Name: </label>
      <input type="text" name="name" id="name" value="<?php echo $name ?>"><br>

      <label for="age">Tel: </label>
      <input type="number" name="tel" id="tel" value="<?php echo $tel ?>"><br>

      <label for="email">Email: </label>
      <input type="email" name="email" id="email" value="<?php echo $email ?>"><br>

      <label for="url">Website (try adding spaces): </label>
      <input type="url" name="url" id="url" value="<?php echo $url ?>"><br>

      <input type="submit" name="submit">
    </form>

  </body>
</html>