<?php
include ("class_lib.php");

Account::$high = .22;
Account::$rate = .15;
$sum= 7;

echo 'High Interest Static $'. Account::getHigh($sum);

$acct = new Account('Ivy Stone', 12345678, $sum);
echo "High Interest NonStatic $". $acct->getHigh($sum);
echo "Low Interest NonStatic $" . $acct->getInterest();
?>