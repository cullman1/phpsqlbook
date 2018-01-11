
<!DOCTYPE html>
<html>
  <head>
  <link href="css/styles.css?a=1" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Nunito|Roboto+Condensed" rel="stylesheet">
  </head>
  <body style="margin:10px;">

    <h2>Please Supply Online details</h2>
    <form action="sanitize.php" method="post">
      <label for="email">Email<label>
      <input id="email" name="email" type="text"/><br/><br/>
      <label for="url">Url</label>
      <input id="url" name="url" type="text"/><br/>   <br/>  
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
