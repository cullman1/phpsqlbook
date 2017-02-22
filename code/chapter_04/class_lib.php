<?php

class Account {
  public $name;
  public $account;
  private $balance;
  public static $interestRate;

  function __construct($name, $account, $balance) { 
   $this->name = $name;
   $this->account = $account;
   $this->balance = $balance; 
 }

  function deposit($amount) {
    $this->balance = $this->balance + $amount;
    return $this->balance;
  }

  function withdraw($amount){
     $this->balance = $this->balance - $amount;
     return $this->balance;
  }

  public static function calcInterest($amount, $rate) {
    
    return $amount * $thisrate;
  }

}
?>