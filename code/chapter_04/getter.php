<?php
include("class_lib.php");

$acct = new Account('Ivy Savings', 20148896);
$acct->setBalance(80);
echo '<br/>' . $acct->name . ' $' .$acct->getBalance();

$acct->deposit(35);
echo '<br/>' .$acct->name . ' $' . $acct->getBalance();
?>