<?php 
require_once('../includes/functions.php');
$email    = ( isset($_POST['email'])    ? $_POST['email']    : '' ); 
$password = ( isset($_POST['password']) ? $_POST['password'] : '' ); 
$error    = array('email' => '', 'password' =>'');
$alert  =   array('status' => '', 'message' =>'');
if($_SERVER['REQUEST_METHOD'] == 'POST') {

  $Validate = new Validate();
  $error['email']     = $Validate->isEmail($email);
  $error['password']  = $Validate->isPassword($password);
  $valid = implode($error);
  if (strlen($valid) > 0 ) {
    $alert = array('status'  => 'danger', 'message' => 'Please check and resubmit');  
  } else {
    $user=get_user_by_email_password($email, $password);
    if ($user) {
      create_user_session($user);
      header('Location:  /phpsqlbook/admin/'); 
    } else {
       $alert = array('status'  => 'danger', 'message' => 'Login failed');
    }
  }
} 
 ?>
<form method="post" action="/phpsqlbook/login/login/">
    <span class="<?= $alert['status']; ?>"><?= $alert['message']; ?></span>
  <label>Email address  
    <input type="email" name="email" placeholder="Email" id="email"> 
   <span class="error"><?= $error['email']; ?></span>
</label><br/>
  <label >Password 
   <input type="password" name="password" placeholder="Password" id="password"> 
   <span class="error"><?= $error['password']; ?></span>
  </label> <br/>
  <button type="submit" class="btn btn-default">Login</button>
</form>
