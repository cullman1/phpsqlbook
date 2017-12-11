<?php
$start    = new DateTime('2000-1-1');
$end      = new DateTime('2001-1-1');
$interval = new DateInterval('P1M');

$period = new DatePeriod($start, $interval, $end);

foreach($period as $event) {
    echo 'In ' . $event->format('Y jS F');
    echo ' was a ' . $event->format('l') . 
    '<br>';
}
?>