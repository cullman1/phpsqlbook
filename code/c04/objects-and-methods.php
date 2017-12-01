<?php
  class Account {
    public $type;
    public $number;
    public $balance;

    function deposit($amount) {
      $this->balance += $amount;
      return $this->balance;
    }
    function withdraw($amount) {
      $this->balance -= $amount;
      return $this->balance;
    }
  }

  $account = new Account();
  $account->balance = 100;

  include 'includes/header.php';
  echo '<br/>$' .$account->deposit(50);
?>