<?php
require_once('../includes/database-connection.php');
require_once('../includes/class-lib.php');
require_once('../includes/functions.php');

$alert  = array('status' => '', 'message' =>'');          // Create as one - I think at this point
$errors = array('email' => '', 'password'=>'');             // Form errors

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $Validate = new Validate();
    $errors['email']     = $Validate->isEmail($_POST["email"]);
    $errors['password']  = $Validate->isPassword($_POST["password"]);
    $valid = implode($errors);
    if (strlen($valid) < 1 ) {
       $alert = submit_login($_POST["email"], $_POST["password"]); 
    } 
} ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Log in</title>
</head>

<body>

  <div class="container">
    <div class="panel panel-default">
      <div class="panel-heading">Log in:</div>
      <div class="panel-body">

        <form method="POST" action="login.php">

          <div id="Status"><span class="<?= $alert['status']; ?>"><?= $alert['message']; ?></span></div>

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

</body>
</html>
<link rel="stylesheet" href="lib/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="lib/bootstrap/css/bootstrap-theme.min.css">