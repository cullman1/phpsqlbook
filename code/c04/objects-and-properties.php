<?php
  class Customer {
    public $forename;
    public $surname;
    public $email;
    public $password;
  }
  class Account {
    public $type;
    public $number;
    public $balance;
  }

  $customer = new Customer();
  $account  = new Account();
  $customer->email  = 'ivy@example.org';
  $account->balance = 14.99;

  include 'includes/header.php';
?>
<p><?php echo 'Email: '    . $customer->email; ?></p>
<p><?php echo 'Balance: $' . $account->balance; ?></p>

<?php include 'includes/footer.php'; ?>