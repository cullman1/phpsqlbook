<?php
include ("class_lib.php");

$account = new Account('Ivy', 12345678, 10);
SavingsAccount::$fee = 3;
$save = new SavingsAccount('Ivy Saver', 12345678, 100);


echo $account->name . " - $" . $account->getBalance();
echo $save->name . " - $" . $save->getBalance();
?>