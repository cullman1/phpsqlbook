<?php
include ("class_lib.php");

$sum= 5;
echo 'Before Object creation STATIC calls<br/>';
echo 'Interest $' . Account::staticInterest($sum, .15);
echo '<br/>After Object creation NONSTATIC calls<br/>';
$acct = new Account('Ivy Stone', 12345678, $sum);
echo "Interest $" . $acct->staticInterest($sum, .15);
echo "<br/>Interest $" . $acct->calcInterest(.15);
?>