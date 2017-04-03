<?php
include('class_lib.php');

SavingsAccount::$fee = 3;

$image1 = array('name'=>'ivy.jpg','alt'=>'Ivy avatar');
$user1  = new User('Ivy Stone', $image1, 12345679);
$account1 = new SavingsAccount('Ivy Stone Savings',12345679,  300);
$image2 = array('name'=>'morton.jpg','alt'=>'Morton avatar');
$user2  = new User('Morton Walsh', $image2, 12345678);
$account2 = new SavingsAccount('Morton Walsh Savings',12345678,  100);
$image3 = array('name'=>'bernie.jpg','alt'=>'Ivy avatar');
$user3  = new User('Bernie Day', $image3, 44145872);
$account3 = new Account('Bernie Day Checking', 44145872,  200);

$users = array($user1, $user2, $user3);

$accounts = array($account1, $account2, $account3);
?>
<table>
  <tr>
    <th>Name</th>
    <th>Image</th>
    <th>Number</th>
     <th>Balance</th>
  </tr>
  <?php
    foreach ($users as $user) {
      echo '<tr>';

      foreach ($user as $key => $value) {
        echo '<td>' . $value . '</td>';
      }
      echo '<td>' . $user->getImage() . '</td>';
      
      foreach ($accounts as $account) {
       if ($account->number == $user->accountNumber) {
         echo '<td>$' . $account->getBalance() . '</td>';
       }
     }  
     echo '</tr>';
   }
?>
</table>