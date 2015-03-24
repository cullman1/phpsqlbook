<?php
  if (isset($_POST['submit'])) {
    $age   = $_POST['age'];
    $email = $_POST['email'];
    $url   = $_POST['url'];
    
    $valid = true;

    if (filter_var($age, FILTER_VALIDATE_INT) == false) {
      $errorAge = 'Please enter a number';
      $valid = false;
    }

    if (filter_var($email, FILTER_VALIDATE_EMAIL) == false) {
      $errorEmail = 'Please enter a valid email address';
      $valid = false;
    }

    if (filter_var($url, FILTER_VALIDATE_URL) == false) {
      $errorURL = 'Please enter a valid URL';
      $valid = false;
    }

    if ($valid == true) {echo 'Your data is valid';}
  }
?>
<!DOCTYPE html>
<html>
  <head><title>Sanitize</title></head>
  <body>

    <form action="validate.php" method="post">
      <label for="age">Age: </label>
      <input type="number" name="age" id="age" value="<?php echo $age ?>">
      <?php echo $errorAge; ?><br>

      <label for="email">Email: </label>
      <input type="email" name="email" id="email" value="<?php echo $email ?>">
      <?php echo $errorEmail; ?><br>

      <label for="url">Website: </label>
      <input type="url" name="url" id="url" value="<?php echo $url ?>">
      <?php echo $errorURL; ?><br>

      <input type="submit" name="submit">
    </form>

  </body>
</html>