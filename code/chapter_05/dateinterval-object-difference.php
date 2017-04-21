<?php
$event_date = new DateTime('2050-12-31 20:30');
$now        = new DateTime();
$interval   = $now->diff($event_date);
?>

Countdown to event:<br>
<?php
echo $interval->format('%y years %m months %d days');
?>