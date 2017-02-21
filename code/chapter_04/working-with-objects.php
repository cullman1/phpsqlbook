<?php
  include('class_lib.php');
  $acct1 = new Account('Ivy Stone', 33344443, 32);
  $acct2 = new Account('Tom White', 43161176, 56);
  $acct3 = new Account('Bernie Day ', 25975383, 14);
?>
<table>
  <tr>
    <th>Date</th>
    <th><?php echo $acct1->name; ?></th>
    <th><?php echo $acct2->name; ?></th>
    <th><?php echo $acct3->name; ?></th>
  </tr>
  <tr>
    <td>23 June</td>
    <td>$<?php echo $acct1->balance; ?></td>
    <td>$<?php echo $acct2->balance; ?></td>
    <td>$<?php echo $acct3->balance; ?></td>
  </tr>
  <?php
    $acct1->withdraw(3);
    $acct2->deposit(12);
    $acct3->deposit(7); 
  ?>
  <tr>
    <td>24 June</td>
    <td>$<?php echo $acct1->balance; ?></td>
    <td>$<?php echo $acct2->balance; ?></td>
    <td>$<?php echo $acct3->balance; ?></td>
  </tr>
 <?php
    $acct1->withdraw(3);
    $acct2->withdraw(9);
    $acct3->deposit(7); 
  ?>
    <tr>
    <td>25 June</td>
    <td>$<?php echo $acct1->balance; ?></td>
    <td>$<?php echo $acct2->balance; ?></td>
    <td>$<?php echo $acct3->balance; ?></td>
  </tr>

  </table>