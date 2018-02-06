<?php
require_once('../config.php');

$forename  = ( isset($_POST['forename']) ? $_POST['forename'] : '' ); 
$surname   = ( isset($_POST['surname'])  ? $_POST['surname']  : '' ); 
$email     = ( isset($_POST['email'])    ? $_POST['email']    : '' ); 
$password  = ( isset($_POST['password']) ? $_POST['password'] : '' ); 
$confirm   = ( isset($_POST['confirm'])  ? $_POST['confirm']  : '' ); 
$errors    = array('forename' => '', 'surname' =>'', 'email' => '', 'password' => '', 'confirm' => '');
$alert     = '';
$show_form = TRUE;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors['forename'] = (Validate::isName($forename) ? '' : 'Please enter a valid forename (Html characters are not allowed).');
    $errors['surname']  = (Validate::isName($surname) ? '' : 'Please enter a valid surname  (Html characters are not allowed).');
    $errors['email']    = (Validate::isEmail($email) ? '' : 'Please enter a valid email.');
    $errors['password'] = (Validate::isPassword($password) ? '' : 'Please enter a valid password.');
    $errors['confirm'] = (Validate::isConfirmPassword($password, $confirm)? '' : 'Please make sure passwords match.');

    if (strlen(implode($errors)) < 1) {
        if (!empty($userManager->getUserByEmail($email))) {
            $alert = '<div class="alert alert-danger">That email is already in use</div>';
        } else {
            $user = new User(0,$forename, $surname, $email, $password, 0);
            $check = $userManager->checkSuperAdmin();
            if ($check==0) {
                $result = $userManager->createSuperAdmin($user);
            } else {
                $user->role = 1;
                $result = $userManager->create($user);
            }
        }
    }

    if ( isset($result) && ( $result === TRUE ) ) {
        if ($user->role == 0) {
            $alert = '<div class="alert alert-success">Administrator added</div>'; 
         }
    if ($user->role == 2) {
            $alert = '<div class="alert alert-success">User added</div>'; 
         }
        $show_form = false;
    }

    if ( isset($result) && ( $result !== TRUE ) ) {
        $alert = '<div class="alert alert-danger">' . $result . '</div>';
    }
} 
include '../includes/header.php';

?>
  <div class="container mt-4 mb-4">
    <div class="row justify-content-md-center">
      <div class="col col-lg-4">

        <h4>Create Administrator</h4>
        <?=$alert;?>

        <?php if ($show_form === TRUE) { ?>
          <form action="" method="POST">
            <div class="form-group">
              <label for="forename">Forename: </label>
              <input name="forename" id="forename" value="<?= htmlspecialchars($forename, ENT_QUOTES, 'UTF-8'); ?>" class="form-control">
              <span class="errors"><?= $errors['forename'] ?></span>
            </div>
            <div class="form-group">
              <label for="surname">Surname: </label>
              <input name="surname" id="surname" value="<?= htmlspecialchars($surname, ENT_QUOTES, 'UTF-8'); ?>" class="form-control">
              <span class="errors"><?= $errors['surname'] ?></span>
            </div>
            <div class="form-group">
              <label for="email">Email: </label>
              <input type="email" name="email" id="email" value="<?= htmlspecialchars($email, ENT_QUOTES, 'UTF-8'); ?>" class="form-control">
              <span class="errors"><?= $errors['email'] ?></span>
            </div>
            <div class="form-group">
              <label for="password">Password: </label>
              <input type="password" name="password" id="password" value="<?= htmlspecialchars($password, ENT_QUOTES, 'UTF-8'); ?>" class="form-control">
              <span class="errors"><?= $errors['password'] ?></span>
            </div>
            <div class="form-group">
              <label for="password">Confirm password: </label>
              <input type="password" name="confirm" id="confirm" value="<?= htmlspecialchars($confirm, ENT_QUOTES, 'UTF-8'); ?>" class="form-control">
              <span class="errors"><?= $errors['confirm'] ?></span>
            </div>
            <input type="submit" name="create" value="create administrator" style="background-color:#dddddd" class="btn btn-default">
          </form>
        <?php } ?>

      </div>
    </div>
  </div>

<?php include '../includes/footer.php'; ?>