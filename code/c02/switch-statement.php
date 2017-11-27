<?php
  $day = 'Monday';
?>
<!DOCTYPE html>
<html>
<head>
  <title>Variables</title>
  <link rel="stylesheet" href="css/styles.css" />
</head>
<body>
  <h1>The Candy Store</h1>
  <h2>Offers on  <?php echo $day; ?></h2>
  <p>
  <?php
    switch ($day) {
      case 'Monday':
        echo '20% off chocolates';
        break;
      case 'Tuesday':
        echo '20% off mints';
        break;
      default:
        echo 'Buy three packs, get one free';
    }
  ?>
  </p>
</body>
</html>