<?php
  $id    = ( isset($_POST['id'])    ? $_POST['id']    : '' );
  $title = ( isset($_POST['title']) ? $_POST['title'] : '' );
  $email = ( isset($_POST['email']) ? $_POST['email'] : '' );
  $article = ( isset($_POST['article']) ? $_POST['article'] : '' );
  $error = Array('id'=>'', 'title'=>'', 'email'=>'', 'article'=>'', 'password'=>'');

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include('cms/classes/service/Validate.php');  
    $error['id']      = (Validate::isNumber($id,0,100000) ? '' : 'Not a valid id');
    $error['title']     = (Validate::isText($title) ? '' : 'Not a valid title');         
    $error['email']     = (Validate::isEmail($email) ? '' : 'Not a valid email');            
    $error['password']     = (Validate::isPassword($password) ? '' : 'Not a valid email');   
    // Check more values here
    $valid = implode($error);
    if (strlen($valid) < 1 ) {
      echo 'Your data was valid';
    }
  }
?>
<form action="validate-test.php" method="post">
  Id:      <input type="text"  name="id"    value="<?= $id; ?>">   <?= $error['id']?><br/>
  Title:   <input type="text" name="title" value="<?= $title; ?>"><?= $error['title']?><br/>
  Article: <textarea name="article" value="<?= $article; ?>"><?= $error['article']?><br/>
  Email:   <input type="email" name="email" value="<?= $email; ?>"><?= $error['email']?><br/>
    Password:   <input type="password" name="password" value="<?= $password; ?>"><?= $error['password']?><br/>
  <!-- Show more form inputs here -->
  <input type="submit" name="submit">
</form>