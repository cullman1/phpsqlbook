<?php
require_once('../config.php');

$forename  = ( isset($_POST['forename']) ? $_POST['forename'] : '' ); 
$surname   = ( isset($_POST['surname'])  ? $_POST['surname']  : '' ); 
$email     = ( isset($_POST['email'])    ? $_POST['email']    : '' ); 
$password  = ( isset($_POST['password']) ? $_POST['password'] : '' ); 
$confirm   = ( isset($_POST['confirm'])  ? $_POST['confirm']  : '' ); 
$errors    = array('forename' => '', 'surname' =>'', 'email' => '', 'password' => '', 'confirm' => '', 'file' => '');
$alert     = '';
$show_form = TRUE;
$uploadedfile  = FALSE;        // Was image uploaded

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $filename    = $_FILES['file']['name'];
    $mediatype   = $_FILES['file']['type'];
    $temporary   = $_FILES['file']['tmp_name'];
    $filesize    = $_FILES['file']['size'];

    $uploadedfile = (file_exists($_FILES['file']['tmp_name']) && is_uploaded_file($_FILES['file']['tmp_name']) );
    $profile_image    = Validate::sanitizeFileName($filename);

    $errors['forename'] = (Validate::isName($forename) ? '' : 'Please enter a valid forename (Html characters are not allowed).');
    $errors['surname']  = (Validate::isName($surname) ? '' : 'Please enter a valid surname  (Html characters are not allowed).');
    $errors['email']    = (Validate::isEmail($email) ? '' : 'Please enter a valid email.');
    $errors['password'] = (Validate::isPassword($password) ? '' : 'Please enter a valid password.');
    $errors['confirm'] = (Validate::isConfirmPassword($password, $confirm)? '' : 'Please make sure passwords match.');

    if ($uploadedfile) {
      $errors['file'] .= (Validate::isAllowedFilename($filename) ? '' : 'Not a valid filename<br>');
      $errors['file'] .= (Validate::isAllowedExtension($filename) ? '' : 'Not a valid file extension<br>');
      $errors['file'] .= (Validate::isAllowedMediaType($temporary) ? '' : 'Not a valid media type<br>');
      $errors['file'] .= (Validate::isWithinFileSize($filesize, 1000000) ? '' : 'File too large<br>');
      $errors['file'] .= (!file_exists('../uploads/' . $filename) ? '' : 'A file with that name already exists.');
    }

    if (mb_strlen(implode($errors)) < 1) {
        if (!empty($userManager->getUserByEmail($email))) {
            $alert = '<div class="alert alert-danger">That email is already in use</div>';
        } else {
            $user = new User(0,$forename, $surname, $email, $password, 1, $profile_image);
            $result = $userManager->create($user);

            if ($uploadedfile) {
              $moveresult  = $mediaManager->moveImage($profile_image, $temporary);         // Move image
              $thumbresult = $mediaManager->resizeImage($profile_image, 150, TRUE); // Create thumbnail
              if ($moveresult != TRUE || $thumbresult != TRUE) {
                $result .= $moveresult . $thumbresult; // Add the error to result
             }
            }
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
include '../includes/header.php';

?>
  <div class="container mt-4 mb-4">
    <div class="row justify-content-md-center">
      <div class="col col-lg-4">

        <h4>Register</h4>
        <?=$alert;?>

        <?php if ($show_form === TRUE) { ?>
          <form action="" method="POST" enctype="multipart/form-data">
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
            <div class="form-group">
              <label for="file">Upload file: </label>
              <input type="file" name="file" accept="image/*" id="file"  />
              <span class="errors"><?= $errors['file'] ?></span>
            </div>
            <input type="submit" name="create" value="save" style="background-color:#dddddd" class="btn btn-default">
          </form>
        <?php } ?>

      </div>
    </div>
  </div>

<?php include '../includes/footer.php'; ?>