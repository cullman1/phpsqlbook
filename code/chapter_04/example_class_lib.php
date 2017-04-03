<?php
include('includes/class_lib.php');

$customer = new Customer();
$account  = new Account();
$customer->email   = 'ivy@example.org';
$account->balance = 14.99;

echo $customer->email . '<br/>$' . $account->balance;
?>