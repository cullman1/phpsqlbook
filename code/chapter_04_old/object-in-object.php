<?php
class AccountNumber{
  
  public $sortcode;
  public $iban;

  function __construct($sortcode, $iban) {
    $this->sortcode = $sortcode;
    $this->iban = $iban;
  }
}

class Account {
  public $type;
  public $number;
  public $balance;

  function __construct($type, $number, $balance=0) { 
    $this->type    = $type;
    $this->number  = $number;
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


//Create an array to store in the property
$account_number = new AccountNumber(402355, 12345678);

//Create an instance of the class and set properties
$account = new Account('Savings', $account_number, 10);
?>

<h1><?php echo $account->type; ?> account</h1>
Sortcode <?php echo $account->number->sortcode; ?><br>
IBAN     <?php echo $account->number->iban; ?><br>

