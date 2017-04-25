<!DOCTYPE html>
<html>
<head>
  <title>Built-in functions, objects and arrays</title>
  <link rel="stylesheet" href="css/styles.css" />
</head>
<body>
<b>Today is:</b>
<?php
$calendar_item = new DateTime();
echo $calendar_item->format('D d M Y, g: i a');
?><br>

<b>Event date:</b>
<?php
$calendar_item->setDate(2020, 12, 12);
$calendar_item->setTime(21, 30);
echo $calendar_item->format('D d M Y, g: i a');
?><br>

<b>End time:</b>
<?php
$calendar_item->modify('+2 hours 45 min');
echo $calendar_item->format('D d M Y, g: i a');
?>
</body>
</html>