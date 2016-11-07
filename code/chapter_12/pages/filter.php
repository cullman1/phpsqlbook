 <?php 

  $id        = ( isset($_POST['id'])       ? $_POST['id']       : '' );
  $title     = ( isset($_POST['title'])    ? $_POST['title']    : '' );
  $article   = ( isset($_POST['article'])  ? $_POST['article']  : '' );
  $template  = ( isset($_POST['template']) ? $_POST['template'] : '' );
  $email     = ( isset($_POST['email'])    ? $_POST['email']    : '' );
  $password  = ( isset($_POST['password']) ? $_POST['password'] : '' );
  $mimetype  = ( isset($_POST['mimetype']) ? $_POST['mimetype'] : '' );
  $month     = ( isset($_POST['month'])    ? $_POST['month']    : '' );
  $day       = ( isset($_POST['day'])      ? $_POST['day']      : '' );
  $year      = ( isset($_POST['year'])     ? $_POST['year']     : '' );
  $hours     = ( isset($_POST['hours'])    ? $_POST['hours']     : '' ); 
  $mins      = ( isset($_POST['mins'])     ? $_POST['mins']     : '' ); 
  $date_time = Array($month, $day, $year, $hours, $mins);

  $error = Array('id'=>'', 'title'=>'', 'article'=>'', 'template'=>'', 'email'=>'', 'password'=>'', 'mimetype'=>'', 'date'=>'', 'date_time'=>'');


  if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    include('../classes/validate.php');

    $Validate = new Validate();

    $date_array         = Array($month, $day, $year);
    $date_time_array    = Array($month, $day, $year, $hours, $mins);

    $error['id']        = $Validate->isID($id);
    $error['title']     = $Validate->isArticleTitle($title);
    $error['article']   = $Validate->isArticleContent($article);
    $error['template']  = $Validate->isCategoryTemplate($template);
    $error['email']     = $Validate->isEmail($email);
    $error['password']  = $Validate->isPassword($password);
    $error['mimetype']  = $Validate->isMimetype($mimetype);
    $error['date']      = $Validate->isDate($date_array);
    $error['date_time'] = $Validate->isDateAndTime($date_time_array);

    $valid = implode($error);

    if (strlen($valid) < 1 ) {
      echo 'Your data was valid';
      // This is where the code to validate your for would go
      // And you would not show the form again
    }

  }
?>
<!DOCTYPE html>
<html>
<head>
  <title>Using Filters To Validate Multiple Values in a Form</title>
</head>
<body>
  <form action="filter.php" method="post">
    id:       <input type="text"     name="id"       value="<?= $id; ?>">       <?= $error['id']?><br>
    Title:    <input type="email"    name="title"    value="<?= $title; ?>">    <?= $error['title'];?><br>
    Article:  <textarea name="article" value="<?= $article; ?>" rows="10" cols="30"><?= $article ?> </textarea><?= $error['article']?><br>
    File:     <input type="template" name="template" value="<?= $template; ?>">    <?= $error['template']?><br>
    Email:    <input type="email"    name="email"    value="<?= $email; ?>">    <?= $error['email']?><br>
    <!-- same for URL / IP address using filter -->
    Password: <input type="password" name="password" value="<?= $password; ?>"> <?= $error['password']?><br>
    Mimetype: <input type="text"     name="mimetype" value="<?= $mimetype; ?>"> <?= $error['mimetype']?><br>
    <br>
    Month:    <input type="text"     name="month"    value="<?= $month; ?>" size="3" > 
    Day:      <input type="text"     name="day"      value="<?= $day;   ?>" size="3" > 
    Year:     <input type="text"     name="year"     value="<?= $year;  ?>" size="5" > <?= $error['date']?><br>
    Hours:    <input type="text"     name="hours"    value="<?= $hours; ?>" size="3" >
    Minutes:  <input type="text"     name="mins"     value="<?= $mins;  ?>" size="3" > <?= $error['date_time']?><br>
    <br>

    <input type="submit" name="submit">
 </form>
</body>
</html>
