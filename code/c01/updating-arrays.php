<?php 
  $nutrition = array('fat' => 38, 'sugar' => 51, 
                     'salt' => 0.25);
  $nutrition['fat']   = 36;
  $nutrition['fibre'] = 2.1;
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Updating Arrays</title>
    <link rel="stylesheet" href="css/styles.css" />
  </head>
  <body>
    <h1>The Candy Store</h1>
    <h2>Nutrition (per 100g)</h2>
    <p>Fat:   <?php echo $nutrition['fat']; ?>%</p>
    <p>Sugar: <?php echo $nutrition['sugar']; ?>%</p>
    <p>Salt:  <?php echo $nutrition['salt']; ?>%</p>
    <p>Fibre: <?php echo $nutrition['fibre']; ?>g</p>
  </body>
</html>