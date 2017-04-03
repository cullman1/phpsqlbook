<?php
include("class_lib.php");

$user = new User();
$user->name = "Morton Walsh";
$account = new Account();
$account->__construct();
$account->balance = 14.99;

echo  $user->name;
echo '<br/>$' . $account->balance;
?>