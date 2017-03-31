<?php

error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', TRUE);
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

  $checking = new Account('Checking', '43161176', 32);
  $savings  = new Account('Savings',  20148896, 756);
?>
<html>
<h1>Account balances</h1>
<table>
  <tr>
    <th>Date</th>
    <th><?php echo $checking->type; ?></th>
    <th><?php echo $savings->type; ?></th>
  </tr>
  <tr>
    <td>23 June</td>
    <td>$<?php echo $checking->balance; ?></td>
   <td>$<?php echo $savings->balance; ?></td>
  </tr>
  <tr>
    <td>24 June</td>
    <td>$<?php echo $checking->deposit('12');  ?></td>
    <td>$<?php echo $savings->withdraw(100); ?></td>
  </tr>
  <tr>
    <td>25 June</td>
    <td>$<?php echo $checking->withdraw(5); ?></td>
    <td>$<?php echo $savings->deposit(300); ?></td>
   </tr>
</table>
  </html>