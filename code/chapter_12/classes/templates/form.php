<?php 
$message='';
if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
    include('../classes/validate.php');
    $Validate = new Validate();
    $this->error['email']     = $Validate->isEmail($_POST["emailAddress"]);
    $this->error['password']   = $Validate->isPassword($_POST["password"]);
    $valid = implode($this->error);
    if (strlen($valid) < 1 ) {
       $message = submit_login($this->connection, $this->registry); 
    } 
} ?>

<form method="post" action="/phpsqlbook/login/login/">
  <h1>Please login:</h1>
    <div id="Status" style="color:red;" ><br/>
   <span style="color:red;"><?= $message ?></span><br><br/>
</div>
  <div class="form-group">
   <label for="emailAddress">Email address
 <input type="email" name="emailAddress" placeholder="Email"> <span class="error"><?= $this->error['email']; ?></span></label><br/><br/>
   <label for="password">Password
   <input type="password" name="password"  placeholder="Password"> <span class="error"><?= $this->error['password']; ?></span></label>
  </div><br/>
<button type="submit" class="btn btn-default">Login</button>
</form>
