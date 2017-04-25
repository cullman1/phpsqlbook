<!DOCTYPE html>
<html>
<head>
  <title>Built-in functions, objects and arrays</title>
  <link rel="stylesheet" href="css/styles.css" />
</head>
<body>
<?php
$now   = new DateTime();
$month = new DateInterval('P1M');

$now->sub($month); 
echo 'Started: ' . $now->format('l jS F Y') . '<br>';
$now->add($month); 

$now->add(new DateInterval('P1Y'));
echo 'Ends: ' . $now->format('l jS F Y') . '<br>';
?>
</body>
</html>