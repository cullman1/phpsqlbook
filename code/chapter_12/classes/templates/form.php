<?php 
require_once('../classes/functions.php');
$alert  =   array('status' => '', 'message' =>'');
if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
    include_once('../classes/validate.php');
    $Validate = new Validate();
    $this->error['email']     = $Validate->isEmail($_POST["emailAddress"]);
    $this->error['password']  = $Validate->isPassword($_POST["password"]);
    $valid = implode($this->error);
    if (strlen($valid) < 1 ) {
       $alert = submit_login($this->connection, $_POST["emailAddress"], $_POST["password"]); 
    } 
} ?>

<form method="post" action="/phpsqlbook/login/login/">
  <h1>Please login:</h1>
    <div id="Status" style="color:red;" ><br/>
          <span class="<?= $alert['status']; ?>"><?= $alert['message']; ?></span><br><br>
</div>
   <label for="emailAddress">Email address
 <input type="email" name="emailAddress" placeholder="Email"> <span class="error"><?= $this->error['email']; ?></span></label><br/><br/>
   <label for="password">Password
   <input type="password" name="password"  placeholder="Password"> <span class="error"><?= $this->error['password']; ?></span></label>
  </div><br/>
<button type="submit" class="btn btn-default">Login</button>
</form>
