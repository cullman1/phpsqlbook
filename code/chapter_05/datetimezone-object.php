<?php
$tz_LDN = new DateTimeZone('Europe/London');
$tz_NYC = new DateTimeZone('America/New_York');

$LDN = new DateTime('now', $tz_LDN);
$NYC = new DateTime('now', $tz_NYC);
$TYO = new DateTime('now', new DateTimeZone('Asia/Tokyo'));

echo 'LDN: ' . $LDN->format('g:i a');
echo ' (' . ($LDN->getOffset() / (60 * 60)) . ')<br>';
echo 'NYC: ' . $NYC->format('g:i a');
echo ' (' . ($NYC->getOffset() / (60 * 60)) . ')<br>';
echo 'TYO: ' . $TYO->format('g:i a');
echo ' (' . ($TYO->getOffset() / (60 * 60)) . ')<br>';

echo '<h2>Head Office</h2>';
echo $tz_LDN->getName() . '<br>';
$location  = $tz_LDN->getLocation();
echo 'Longitude: ' . $location['longitude'] . '<br>';
echo 'Latitude: ' . $location['latitude'];
?>
