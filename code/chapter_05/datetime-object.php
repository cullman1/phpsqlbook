<!DOCTYPE html>
<html>
<head>
  <title>Built-in functions, objects and arrays</title>
  <link rel="stylesheet" href="css/styles.css" />
</head>
<body>
<?php
  // Create new DateTime object (defaults to now)
  $now = new DateTime();

  // Create new DateTime object to represent date shown
  $expires = new DateTime('2020-12-31 23:59');
?>

<p>Current time: 
<?php echo $now->format('D d M Y, g: i a'); ?>
</p>

<p>Offer expires on 
  <?php echo $expires->format('D d M Y'); ?>
  at 
  <?php echo $expires->format('g:i a'); ?>
</p>
</body>
</html>