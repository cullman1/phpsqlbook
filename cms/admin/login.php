<?php
require_once('/includes/config.php');
require_once('/includes/classes/service/Validate.php');

$cms                = new CMS($database_config);
$userManager    = $cms->getUserManager();
$email    = ( isset($_POST['email'])    ? $_POST['email']    : '' ); 
$password = ( isset($_POST['password']) ? $_POST['password'] : '' ); 
$alert  = array('status' => '', 'message' =>'');          // Create as one - I think at this point
$errors = array('email' => '', 'password'=>'');             // Form errors

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors['email']     = Validate::isEmail($_POST["email"]);
    $errors['password']  = Validate::isPassword($_POST["password"]);
    $valid = implode($errors);
    if (strlen($valid) < 1 ) {
       $alert = submit_login($_POST["email"], $_POST["password"]); 
    } 
} ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Log in</title>
  <style>
  .login {margin-top: 3em;}
  </style>
</head>

<body>
  <div class="container">
  <h1>Simple CMS</h1>
    <div class="col-md-8 col-md-offset-2 login">
      <div class="panel panel-default">
        <div class="panel-heading">Log in:</div>
        <div class="panel-body">

          <form method="POST" action="login.php">

            <div class="alert alert-<?= $alert['status']; ?>"><?= $alert['message']; ?></div>

            <div class="form-group">
              <label for="email">Email address</label>
              <input type="email" name="email" placeholder="Email" id="email"> <span class="error"><?= $errors['email']; ?></span>
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" name="password" placeholder="Password" id="password"> <span class="error"><?= $errors['password']; ?></span>
            </div>

            <button type="submit" class="btn btn-default">Login</button>

          </form>

        </div>
      </div>
    </div>
  </div>

</body>
</html>
<link rel="stylesheet" href="lib/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="lib/bootstrap/css/bootstrap-theme.min.css">