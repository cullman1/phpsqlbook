<?php

$date = new DateTime('+24 hours');
$newdate = serialize($date->format('Y/m/d'));
echo("Date:".$newdate);
?>