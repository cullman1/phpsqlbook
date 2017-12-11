<?php
$date       = new DateTime();
$event_date = new DateTime('2025-12-31 20:30');
$countdown  = $date->diff($event_date);

$interval   = new DateInterval('P1M');
$date->add($interval);
?>

<h2>Countdown to event:</h2>
<?php
echo $countdown->format('%y years %m months %d days');
?>
<h2>50% off tickets bought by:</h2>
<?php 
echo $date->format('D d M Y, g:i a');
?>