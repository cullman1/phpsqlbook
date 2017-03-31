<?php 
  $best_sellers = array(
    'Chocolate', 'Mint', 'Bubble gum', 'Toffee', 
    'Jelly Beans', 'Fudge', 'Gobstoppers');
?>
<!DOCTYPE html>
<html>
<head>
  <title>Indexed Arrays</title>
  <link rel="stylesheet" href="css/styles.css" />
</head>
<body>
  <h1>Best Sellers</h1>
  <ul>
    <li><?php echo $best_sellers[0]; ?></li>
    <li><?php echo $best_sellers[1]; ?></li>
    <li><?php echo $best_sellers[2]; ?></li>
  </ul>
  <p>(Total items: 7)</p>
</body>
</html>