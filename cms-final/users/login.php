<?php
require_once('../config.php');

$email    = ( isset($_POST['email'])    ? $_POST['email']    : '' );
$password = ( isset($_POST['password']) ? $_POST['password'] : '' ); 
$alert  = '';
$error = array('email' => '', 'password'=>'');             // Form errors

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $error['email']     = (Validate::isEmail($email) ? '' : 'Please enter a valid email address.');
    $error['password']  = (Validate::isPassword($password) ? '' : 'Your password must contain 1 uppercase letter, 1 lowercase letter, 
            and a number. It must be between 8 and 32 characters.\'');
    $valid = implode($error);

    if (mb_strlen($valid) > 0 ) {
      $alert = '<div class="alert alert-danger">Please check your login details</div>';
    } else {
      $user = $userManager->getUserByEmailPassword($email, $password);
      if ($user) {
        $userManager->createUserSession($user);
        header('Location: ' . ROOT . 'index.php');
      } else {
        $alert = '<div class="alert alert-danger">Login failed</div>';
    }
  }

}

include dirname(__DIR__) . '/includes/header.php';

?>
    <div class="container mt-4 mb-4">
      <div class="row justify-content-md-center">
        <div class="col col-lg-4">

          <form class="login-form" method="post" action="">
            <h4 class="card-title">Login</h4>
            <?= $alert ?>
            <label for="email">Email</label><br>
            <input type="text" name="email" id="email" placeholder="Email" class="form-control" /><br>
            <div class="title-error"><?= $error['email']; ?></div>
            <label for="password">Password</label><br>
            <input type="password" name="password" placeholder="Password" class="form-control" /><br>
            <div class="error"><?= $error['password']; ?></div>
            <button type="submit" class="btn btn-primary">Login</button><br>
            <a href="<?= ROOT ?>users/forgotten-password.php" class="card-link">Forgotten your password?</a> <br>
          </form>
        </div>
      </div>
    </div>

<?php include '../includes/footer.php';  ?>