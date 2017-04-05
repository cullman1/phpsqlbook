<?php
  function create_logo() {
    return '<img src="images/logo.png" alt="Logo" />';
  }

  function create_copyright_notice() {
    $year    = date('Y');
    $message = '&copy; ' . $year;
    return $message;
  }

  $copyright_notice = create_copyright_notice()
?>
<!doctype html>
<html>
<head>
  <title>The Candy Store</title>
  <link rel="stylesheet" href="css/styles.css" />
</head>
<body>
  <header>
    <h1><?php echo create_logo(); ?>The Candy Store</h1>
  </header>
  <article>
    <h2>Welcome to The Candy Store.</h2>
  </article>
  <footer>
    <?php echo create_logo(); ?>
    <?php echo $copyright_notice; ?>
  </footer>
</body>
</html>