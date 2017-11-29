<?php
  class Customer {
    public $forename;
    public $surname;
    public $email;
    public $password;
  }
  class Account {
    public $type;
    public $number;
    public $balance;
  }

  $customer = new Customer();
  $account  = new Account();
  $customer->email  = 'ivy@example.org';
  $account->balance = 14.99;

  include 'includes/header.php';
  echo $customer->email . '<br/>$' . $account->balance;
?>