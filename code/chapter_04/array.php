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

//Create an array to store in the property
$account_number = array( 'sortcode' => 402355,
                         'iban'     => 12345678);

//Create an instance of the class and set properties
$account = new Account($account_number,'Savings',  10);
?>

<h1><?php echo $account->type; ?> account</h1>
Sortcode <?php echo $account->number['sortcode']; ?><br>
IBAN     <?php echo $account->number['iban']; ?><br>