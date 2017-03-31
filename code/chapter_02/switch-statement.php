<?php
 $day = 'Monday';
?>
<!DOCTYPE html>
<html>
<head>
  <title>The Candy Store</title>
  <link rel="stylesheet" href="css/styles.css" />
</head>
<body>
  <h1>Offers on  <?php echo $day; ?></h1>
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
</body>
</html>