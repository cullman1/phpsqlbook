<?php 
require_once('../includes/functions.php');
$alert  =   array('status' => '', 'message' =>'');
if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
    include_once('../classes/validate.php');
    $Validate = new Validate();
    $this->error['email']     = $Validate->isEmail($_POST["emailAddress"]);
    $this->error['password']  = $Validate->isPassword($_POST["password"]);
    $valid = implode($this->error);
    if (strlen($valid) < 1 ) {
       $alert = submit_login($this->database, $_POST["emailAddress"], $_POST["password"]); 
    } 
} ?>
<form method="post" action="/phpsqlbook/login/login/">
  <h1>Login:</h1>
  <div id="Status">
    <span class="<?= $alert['status']; ?>"><?= $alert['message']; ?></span>
  </div>
  <div class="form-group">
  <label for="emailAddress">Email address  </label>
    <input type="email" name="emailAddress" placeholder="Email" id="emailAddress"> <span class="error"><?= $this->error['email']; ?></span>
</div>
<div class="form-group">
  <label for="password">Password </label>
   <input type="password" name="password" placeholder="Password" id="password"> <span class="error"><?= $this->error['password']; ?></span>
  </div>
  <button type="submit" class="btn btn-default">Login</button>
</form>
