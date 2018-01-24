<?php
  $id        = ( isset($_POST['id'])    ? $_POST['id']    : '' );
  $title     = ( isset($_POST['title']) ? $_POST['title'] : '' );
  $email     = ( isset($_POST['email']) ? $_POST['email'] : '' );
  $article   = ( isset($_POST['article']) ? $_POST['article'] : '' );
  $password  = ( isset($_POST['password']) ? $_POST['password'] : '' );

  $error = Array('id'=>'', 'title'=>'', 'email'=>'', 'article'=>'', 'password'=>'', 
                 'confirm'=>'', 'date'=>'');
  
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include 'cms/classes/service/Validate.php';  
    $error['id']       = (Validate::isNumber($id,0,100000) ? '' : 'Id not valid');
    $error['title']    = (Validate::isName($title,0,200) ? '' : 'Title not valid');   
    $error['article']  = (Validate::isText($title,0,2000) ? '' : 
                          'The article content is not valid');   
    $error['email']    = (Validate::isEmail($email) ? '' : 'Email address not valid');            
    $error['password'] = (Validate::isPassword($password) ? '' : 'Password not valid');
    
    $valid = implode($error);
    if (strlen($valid) < 1 ) {
      echo 'Your data was valid';
    }
  }
?>
<form action="validate-test.php" method="post">
  Id:      <input type="text"  name="id"   value="<?= $id; ?>"> <?= $error['id']?>
  Title:   <input type="text" name="title" value="<?= $title; ?>"> <?= $error['title']?>
  Article: <textarea name="article"><?= $article; ?></textarea> <?= $error['article']?>
  Email:   <input type="email" name="email" value="<?= $email; ?>">
           <?= $error['email']?>
  Password: <input type="password" name="password" value="<?= $password; ?>">
            <?= $error['password']?>
  <!--More form controls are placed here -->
  <input type="submit" name="submit">
</form>