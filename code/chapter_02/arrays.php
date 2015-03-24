<?php 
$vegetables = array(
    "Beet", "Broccoli", "Carrot", "Corn", "Kale", "Lettuce",
    "Onion", "Parsnip", "Potato", "Squash", "Tomato", 
    "Zucchini");
?>
<!DOCTYPE html>
<html>
<head>...</head>
<body>
  <h1>Top Three Best Sellers</h1>
  <ul>
    <li><?php echo $bestSellers[0]; ?></li>
    <li><?php echo $bestSellers[1]; ?></li>
    <li><?php echo $bestSellers[2]; ?></li>
  </ul>
  <p>Items in list: <?php echo count($bestSellers); ?></p>
</body>
</html>