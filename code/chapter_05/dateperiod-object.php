<?php
$start    = new DateTime('2000-1-1');
$end      = new DateTime('2001-1-31');
$interval = new DateInterval('P1M');

$period = new DatePeriod($start, $interval, $end);

foreach($period as $occurence) {
  echo 'In ' . $occurence->format('Y jS F');
  echo ' will be a ' . $occurence->format('l') . 
    '<br>';
}
?>