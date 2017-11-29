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
class AccountNumber {
  public $sortcode;
  public $iban;

  function __construct($sortcode, $iban) {
    $this->sortcode = $sortcode;
    $this->iban = $iban;
  }
}

// Create an object to store in the property
$account_number = new AccountNumber(402355, 12345678);

// Create instance of Account class and set properties
$account = new Account($account_number,'Savings',  10);
include 'includes/header.php';
?>
<h1><?php echo $account->type; ?> account</h1>
Sortcode: <?php echo $account->number->sortcode; ?><br>
IBAN:     <?php echo $account->number->iban; ?><br>
</body>
</html>