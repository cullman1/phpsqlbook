<?php

class Account {
  var $name;
  var $account;
  var $balance;

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
}
?>