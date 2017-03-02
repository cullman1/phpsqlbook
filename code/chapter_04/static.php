<?php
include ("class_lib.php");

Account::$rate = .15;
$sum= 7;

echo 'Interest Calculated by Static $' .   
Account::getInterest($sum);

$acct = new Account('Ivy Stone', 12345678, $sum);
echo "<br/>Interest Calculated by Non-Static $" . 
$acct->getInterest($sum);
?>