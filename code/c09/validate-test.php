<?php
  $id    = ( isset($_POST['id'])    ? $_POST['id']    : '' );
  $title = ( isset($_POST['title']) ? $_POST['title'] : '' );
  $email = ( isset($_POST['email']) ? $_POST['email'] : '' );
  $article = ( isset($_POST['article']) ? $_POST['article'] : '' );
  $password  = ( isset($_POST['password']) ? $_POST['password'] : '' );
  $confirm  = ( isset($_POST['confirm']) ? $_POST['confirm'] : '' );
  $month     = ( isset($_POST['month'])    ? $_POST['month']    : '' );
  $day       = ( isset($_POST['day'])      ? $_POST['day']      : '' );
  $year      = ( isset($_POST['year'])     ? $_POST['year']     : '' );
  $hours       = ( isset($_POST['hours'])      ? $_POST['hours']      : '' );
  $minutes      = ( isset($_POST['minutes'])     ? $_POST['minutes']     : '' );
  $error = Array('id'=>'', 'title'=>'', 'email'=>'', 'article'=>'', 'password'=>'', 'confirm'=>'', 'date'=>'');

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include('cms/classes/service/Validate.php');  
    $error['id']       = (Validate::isNumber($id,0,100000) ? '' : 'Id not valid');
    $error['title']    = (Validate::isName($title,0,200) ? '' : 'Title not valid');   
    $error['article']  = (Validate::isText($title,0,2000) ? '' : 'Content not valid');   
    $error['email']    = (Validate::isEmail($email) ? '' : 'Email address not valid');            
    $error['password'] = (Validate::isPassword($password) ? '' : 'Password not valid');  
    $error['confirm']  = (Validate::isConfirmPassword($password, $confirm) ? '' : 'Please ensure passwords match'); 
    $error['date']     = (Validate::isDateTime($month, $day, $year, $hours, $minutes) ? '' : 'Not a valid date/time');
    $valid = implode($error);
    if (strlen($valid) < 1 ) {
      echo 'Your data was valid';
    }
  }
?>
<form action="validate-test.php" method="post">
  Id:      <input type="text"  name="id"    value="<?= $id; ?>">   <?= $error['id']?><br/><br/>
  Title:   <input type="text" name="title" value="<?= $title; ?>"> <?= $error['title']?><br/><br/>
  Article: <textarea name="article" rows="5" cols="30"><?= $article; ?></textarea> <?= $error['article']?> <br /><br/>
  Email:   <input type="email" name="email" value="<?= $email; ?>"> <?= $error['email']?><br/><br/>
  Password:   <input type="password" name="password" value="<?= $password; ?>"> <?= $error['password']?><br/><br/>
  Confirm  Password:   <input type="password" name="confirm" value="<?= $confirm; ?>"> <?= $error['confirm']?><br/><br/>
  Month:    <input type="text"     name="month"    value="<?= $month; ?>" size="3" > 
  Day:      <input type="text"     name="day"      value="<?= $day;   ?>" size="3" > 
  Year:     <input type="text"     name="year"     value="<?= $year;  ?>" size="5" >
  Hours:      <input type="text"     name="hours"      value="<?= $hours;   ?>" size="2" > 
  Minutes:     <input type="text"     name="minutes"     value="<?= $minutes;  ?>" size="2" >
  <?= $error['date']?><br/><br/>
  <input type="submit" name="submit">
</form>