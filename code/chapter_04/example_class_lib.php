<?php
include('includes/class_lib.php');

$customer = new Customer();
$account  = new Account();
$customer->email   = 'ivy@example.org';
$account->balance = 14.99;
?>
<!DOCTYPE html>
<html>
<head>
  <title>Objects</title>
  <link rel="stylesheet" href="css/styles.css" />
</head>
<body>
<h1>Account balance</h1>
<?php
echo $customer->email . '<br/>$' . $account->balance;
?>
</body>
</html>