<?php 
require_once('/code/chapter_12/includes/functions.php');
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
    <span class="<?= $alert['status']; ?>"><?= $alert['message']; ?></span>
  <label>Email address  
    <input type="email" name="emailAddress" placeholder="Email" id="emailAddress"> 
   <span class="error"><?= $this->error['email']; ?></span>
</label><br/>
  <label >Password 
   <input type="password" name="password" placeholder="Password" id="password"> 
   <span class="error"><?= $this->error['password']; ?></span>
  </label> <br/>
  <button type="submit" class="btn btn-default">Login</button>
</form>
