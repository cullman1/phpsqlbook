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
  function getBalance(){
    return $this->balance;
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

$account = new Account(20148896, 'Savings', 80);

echo $account->type . ' account' . '<br>'; 
echo '$' . $account->getBalance(); 
echo '<br>';
echo '$' . $account->deposit(35);
?>