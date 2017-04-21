<?php
$now   = new DateTime();
$month = new DateInterval('P1M');

$now->sub($month); 
echo 'Started: ' . $now->format('l jS F Y') . '<br>';
$now->add($month); 

$now->add(new DateInterval('P1Y'));
echo 'Ends: ' . $now->format('l jS F Y') . '<br>';
?>