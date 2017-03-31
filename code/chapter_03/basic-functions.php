<?php
  function write_logo() {
    echo '<img src="images/logo.gif" alt="Logo" />';
  }

  function write_copyright_notice() {
    $year = date('Y');        // Get and store year
    echo '&copy; ' . $year;   // Write copyright notice
  }
?>
<!doctype html>
<html>
<head>
  <title>The Candy Store</title>
  <link rel="stylesheet" href="css/styles.css" />
</head>
<body>
  <header>
    <h1><?php write_logo(); ?> The Candy Store</h1>
  </header>
  <article>
    <p>Welcome to the Candy Store</p>
  </article>
  <footer>
    <?php write_logo(); ?>
    <?php write_copyright_notice(); ?>
  <footer>
  </body>
</html>