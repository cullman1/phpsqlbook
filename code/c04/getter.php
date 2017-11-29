<?php
class Account {
  public $number;
  public $type;
  private $balance;

  function __construct($number, $type, $balance=0) { 
    $this->number  = $number;
    $this->type    = $type;
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
  function getBalance(){
    return $this->balance;
  }
}
$account = new Account(20148896, 'Savings', 80);
include 'includes/header.php';
echo $account->type . ' account' . '<br>'; 
echo 'Old balance: $' . $account->getBalance();
echo ' New balance: $' . $account->deposit(35);
?>
