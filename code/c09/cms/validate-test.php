<?php
  $id        = $_POST['id']   ?? '' ;
  $title     =  $_POST['title'] ?? '' ;
  $email     =  $_POST['email'] ?? '' ;
  $article   =  $_POST['article'] ?? '' ;
  $password  =  $_POST['password'] ?? '' ;

  $error = Array('id'=>'', 'title'=>'', 'email'=>'', 'article'=>'', 'password'=>'', 
                 'confirm'=>'', 'date'=>'');
  
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include 'classes/service/Validate.php';
    $error['id']       = Validate::isId($id);
    $error['title']    = Validate::isArticleTitle($title);
    $error['article']  = Validate::isArticleSummary($article);
    $error['email']    = Validate::isEmail($email);
    $error['password'] = Validate::isPassword($password);
    
    $valid = implode($error);
    if (strlen($valid) < 1 ) {
      echo 'Your data was valid';
    }
  }
?>
<form action="validate-test.php" method="post">
  Id:      <input type="text"  name="id"   value="<?= $id; ?>"> <?= $error['id']?><br/>
  Title:   <input type="text" name="title" value="<?= $title; ?>"> <?= $error['title']?><br/>
  Article: <textarea name="article"><?= $article; ?></textarea> <?= $error['article']?><br/>
  Email:   <input type="email" name="email" value="<?= $email; ?>"> <?= $error['email']?><br/>
  Password: <input type="password" name="password" value="<?= $password; ?>"> <?= $error['password']?><br/>
  <!--More form controls are placed here -->
  <input type="submit" name="submit">
</form>