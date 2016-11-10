<?php 
require_once('../classes/functions.php');
$message='';
$firstName    = ( isset($_POST['firstName'])    ? $_POST['firstName']    : '' ); 
$lastName = ( isset($_POST['lastName']) ? $_POST['lastName'] : '' ); 
$email    = ( isset($_POST['email'])    ? $_POST['email']    : '' ); 
$password = ( isset($_POST['password']) ? $_POST['password'] : '' ); 
$this->error    = array('email' => '', 'password' =>'', 'firstName' => '', 'lastName' =>'');
$alert  =   array('status' => '', 'message' =>'');

if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
  include('../classes/validate.php');
  $Validate = new Validate();
  $this->error['email']      = $Validate->isEmail($email);
  $this->error['password']   = $Validate->isStrongPassword($password);
  $this->error['firstName']  = $Validate->isFirstName($firstName);
  $this->error['lastName']   = $Validate->isLastName($lastName);
  $valid = implode($this->error);
  if (strlen($valid) > 1 ) {
    $alert = array('status'  => 'danger', 'message' => 'Please check and resubmit');  
  } else {
    $alert = submit_register($this->connection, $_POST['firstName'],$_POST['lastName'],$_POST['password'],$_POST['emailAddress']); 
  } 
} 
?> 
<form id="form1" method="post" action="\phpsqlbook\register\">
      <h1>Please register:</h1>
         <span class="<?= $alert['status']; ?>"><?= $alert['message']; ?></span><br><br>
           <label for="emailAddress">Email address
           <input type="email" class="form-control" id="emailAddress" name="emailAddress" placeholder="Enter email">
           <span class="error"><?= $this->error['email']; ?></span></label><br/><br/>
           <label for="firstName">First name
           <input type="text" class="form-control" id="firstName" name="firstName" placeholder="First name">
           <span class="error"><?= $this->error['firstName']; ?> </span></label><br/><br/>
           <label for="lastName">Last name
           <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Last name">
           <span class="error"><?= $this->error['lastName']; ?></span></label><br/><br/>
           <label for="password">Password
           <input type="password" class="form-control" id="password" name="password" placeholder="Password">
            <span class="error"><?= $this->error['password']; ?></span></label><br/><br/>
  <input id="Role" name="Role" type="hidden" value="2">
  <button type="submit" class="btn btn-default">Register</button>
</form>
