<?php
class Customer { 
  public $number;  
  public $forename;
  public $surname;
  private $password;
  public $accounts;

  function __construct($number, $forename, $surname, $password, $accounts) { 
    $this->number = $number;
    $this->forename = $forename; 
    $this->surname = $surname;
    $this->password = $password; 
    $this->accounts = $accounts; 
  } 

   function getFullName() {
     $fullName = $this->forename . ' ' . $this->surname;
     return $fullName;
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

  function getBalance() {
     return  $this->balance;
  }
}

$checking = new Account('Checking', 12345678, -20);
$savings  = new Account('Savings',  12345679, 380);

$accounts = array($checking, $savings);

$user = new Customer(12345678, 'Ivy', 'Stone', 'test',
                 $accounts);
?>

Name: <?php echo $user->getFullName(); ?>
<table>
  <tr>
    <th>Account Number</th>
    <th>Account Type</th>
    <th>Balance</th>
  </tr>
  <?php
    foreach ($user->accounts as $account) {
      echo '<tr>';
      echo '<td>' . $account->number . '</td>';
      echo '<td>' . $account->type . '</td>';
      $balance = $account->getBalance();
      if ($balance >= 0) {
        echo '<td class="credit">'. $balance .'</td>';        
      } else {
        echo '<td class="drawn">'. $balance .'</td>';        
      }
      echo '</tr>';
    }
  ?>
</table>