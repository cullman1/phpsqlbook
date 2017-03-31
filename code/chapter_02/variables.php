<?php 
  $username = 'Ivy';
  $price = 5;
?>
<!DOCTYPE html>
<html>
<head>
  <title>Variables</title>
  <link rel="stylesheet" href="css/styles.css" />
</head>
<body>
  <h1>Candy</h1>
  <p>Welcome <?php echo $username; ?></p>
  <p>The cost of your candy is 
     $<?php echo $price; ?> per pack.</p>
</body>
</html>