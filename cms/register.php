<?php 
require_once('includes/database-connection.php');
require_once('includes/functions.php');
require_once('includes/class-lib.php');
$GLOBALS['root'] = "/phpsqlbook/cms/";
$forename  = ( isset($_POST['forename']) ? $_POST['forename'] : '' ); 
$surname   = ( isset($_POST['surname'])  ? $_POST['surname']  : '' ); 
$email     = ( isset($_POST['email'])    ? $_POST['email']    : '' ); 
$password  = ( isset($_POST['password']) ? $_POST['password'] : '' ); 
$confirm   = ( isset($_POST['confirm'])  ? $_POST['confirm']  : '' ); 
$errors    = array('forename' => '', 'surname' =>'', 'email' => '',
                   'password' => '', 'confirm' => '');
$alert     = '';
$show_form = TRUE;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $user = new User('new', $forename, $surname, $email, $password);
  $Validate = new Validate();   // Create validation object
  $errors = $Validate->isUser($user); 
  $errors['confirm'] = $Validate->isConfirmPassword($password, $confirm);
  if (strlen(implode($errors)) < 1) {
    if (!empty(get_user_by_email($email))) {
      $alert = '<div class="alert alert-danger">That email is already in use</div>';
    } else {
      $result = $user->create();
    } 
  }
  if ( isset($result) && ( $result === TRUE ) ) {
    $alert = '<div class="alert alert-success">User added</div>';   
    $show_form = false;
  }
  if ( isset($result) && ( $result !== TRUE ) ) {
    $alert = '<div class="alert alert-danger">' . $result . '</div>';
  }
}
get_HTML_template('header');
 ?>
<?php if ($show_form) { ?>
<form class="login-form" method="post" action="register.php">
<fieldset>
<legend>Register</legend>
 <div class="title-error"><?= $alert ?></div>
  <label>First name <input type="text" name="forename" value="<?=$forename ?>" />
  </label> <span class="title-error"><?= $errors['forename'] ?></span>
  <label>Last name <input type="text" name="surname" value="<?=$surname ?>" />
  </label> <span class="title-error"><?= $errors['surname'] ?></span>
  <label>Email address <input type="email" name="email" value="<?=$email ?>" />
  </label> <span class="title-error"><?= $errors['email'] ?></span>
  <label>Password <input type="password" name="password" />
  </label> <div class="title-error"><?= $errors['password'] ?></div>
  <label>Confirm Password <input type="password" name="confirm" />
  </label> <span class="title-error"><?= $errors['confirm'] ?></span><br>
   <button type="submit">Register</button><br><br>
   </fieldset>
</form>
<?php } ?>
 <?= get_HTML_template('footer'); ?>