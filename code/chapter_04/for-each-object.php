<?php
include('class_lib.php');
$basil  = new Seed('Basil', 3, 32);
?>
<!DOCTYPE html>
<html>
<head>
  <title>Seeds</title>
  <link rel="stylesheet" href="css/styles.css" />
</head>
<body>
<h1><?php echo $basil->name; ?></h1>

<?php
  foreach ($basil as $property => $value) {
    echo $property . ' ' . $value . '<br>';
  }
?>
</body>
</html>