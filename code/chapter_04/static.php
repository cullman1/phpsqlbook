<?php
class Account {
  public $name;
  public $account;
  private $balance = 4;
  $this->balance = $balance;
 
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