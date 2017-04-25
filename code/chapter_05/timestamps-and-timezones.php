<!DOCTYPE html>
<html>
<head>
  <title>Built-in functions, objects and arrays</title>
  <link rel="stylesheet" href="css/styles.css" />
</head>
<body>
<?php
date_default_timezone_set('Europe/London');

$year 	  = 2016;
$month 	  = 8;
$day 	  = 24;
$hours 	  = 9;
$minutes  = 32;
$seconds  = 64;
$purchase_date = mktime($hours, $minutes, $seconds,
                        $month, $day, $year);

$warranty   = '+12 months';
$end_date   = strtotime($warranty, $purchase_date);
$renew_date = strtotime('previous month', $end_date);
?>
<b>Item purchased: </b>
<?php echo date('D d M Y h:i', $purchase_date); ?><br>
<b>Warranty ends: </b>
<?php echo date('D d M Y h:i', $end_date); ?><br>
<b>Extend warranty by: </b>
<?php echo date('D d M Y', $renew_date); ?><br>
<b>Your timezone is: </b>
<?php echo date_default_timezone_get(); ?>
</body>
</html>