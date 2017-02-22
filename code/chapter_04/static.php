<?php
class Account {
  public $name;
  public $account;
  private $balance;

  function __construct($name, $account, $balance) { 
    $this->name = $name;
    $this->account = $account;
    $this->balance = $balance; 
  }

  public static function staticInterest($amount, $rate)    
  {
    return $amount * $rate;
  }

  public function calcInterest($rate) {
    return $this->balance * $rate;
  }
}

$balance = 5;
echo 'Before Object creation STATIC calls<br/>';
echo 'Interest $' . Account::staticInterest($balance,
                                            .15);

echo '<br/>After Object creation NONSTATIC calls<br/>';
$acct = new Account('Ivy Stone', 12345678, $balance);
echo "Interest $" . $acct->staticInterest($balance, .15);
echo "<br/>Interest $" . $acct->calcInterest(.15);
?>