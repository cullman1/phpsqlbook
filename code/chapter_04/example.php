<?php
include 'classes/Account.php';
include 'classes/Customer.php';
$checking = new Account('Checking', 12345678, -20);
$savings  = new Account('Savings',  12345679, 380);
$accounts = array($checking, $savings);
$customer = new Customer('Ivy', 'Stone', 'ivy@example.org', 'Jup!t3r26', $accounts);
?>
Name: <?php echo $customer->getFullName(); ?>
<!DOCTYPE html>
<html>
<head>
  <title>Objects</title>
  <link rel="stylesheet" href="css/styles.css" />
</head>
<body>
<table>
  <tr>
    <th>Account Number</th>
    <th>Account Type</th>
    <th>Balance</th>
  </tr>
  <?php
    foreach ($customer->accounts as $account) {
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
</body>
</html>