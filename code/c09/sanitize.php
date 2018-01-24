<!DOCTYPE html>
<html>
  <head>...</head>
  <body>
    <h1>Please Supply Online details</h1>
    <form action="sanitize.php" method="post">
      <label for="email">Email<label>
      <input id="email" name="email" type="text"/><br/>
      <label for="url">Url</label>
      <input id="url" name="url" type="text"/><br/>     
      <input type="submit" />
    </form>
    <?php
      $email = filter_input(INPUT_POST, "email", 
                          FILTER_SANITIZE_EMAIL);
      $url = filter_input(INPUT_POST, "url", 
                          FILTER_SANITIZE_URL);
      echo "<br>". $email;
      echo "<br>".$url;
    ?>
  </body>
</html>