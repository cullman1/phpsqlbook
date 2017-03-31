<?php
class Account {
  public $type;
  public $number;
  public $balance;

  function __construct($type, $number, $balance=0) { 
    $this->type = $type;
    $this->number = $number;
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