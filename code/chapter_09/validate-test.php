<?php
  $id    = ( isset($_POST['id'])    ? $_POST['id']    : '' );
  $title = ( isset($_POST['title']) ? $_POST['title'] : '' );
  $email = ( isset($_POST['email']) ? $_POST['email'] : '' );
  // Collect more values here

 $error = Array('id'=>'', 'title'=>'', 'email'=>'');
 // Add a key for each element on the form

 if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include('classes/service/Validate.php');
    

    $error['id']        = Validate::isNumber($id,0,100000);
    $error['title']     = Validate::isText($title);
    $error['email']     = Validate::isEmail($email);
    // Check more values here
    $valid = implode($error);
    if (strlen($valid) < 1 ) {
      echo 'Your data was valid';
    }
  }
?>
<form action="validate-test.php" method="post">
  id:      <input type="text"  name="id"    value="<?= $id; ?>">   <?= $error['id']?>
  Title:   <input type="email" name="title" value="<?= $title; ?>"><?= $error['title']?>
  Email:   <input type="email" name="email" value="<?= $email; ?>"><?= $error['email']?>
  <!-- Show more form inputs here -->
  <input type="submit" name="submit">
</form>