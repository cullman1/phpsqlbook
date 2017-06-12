<?php 
error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', TRUE);
session_start();
require_once('includes/database-connection.php');
require_once('includes/functions.php');
require_once('includes/class-lib.php');
$GLOBALS['root'] = "/phpsqlbook/cms/";
$id    = ( isset($_GET['id'])    ? $_GET['id']    : '' ); 
$email    = ( isset($_POST['Email'])    ? $_POST['Email']    : '' ); 
$forename    = ( isset($_POST['Forename'])    ? $_POST['Forename']    : '' ); 
$surname    = ( isset($_POST['Surname'])    ? $_POST['Surname']    : '' ); 
$files    = ( isset($_FILES['img']['name'])    ? $_FILES['img']['name']    : '' ); 
$files_temp    = ( isset($_FILES['img']['tmp_name'])    ? $_FILES['img']['tmp_name']    : '' ); 
$alert = '';
$error = array('id'=>'', 'title'=>'','article'=>'','template'=>'','email'=>'','password'=>'','mimetype'=>'','date'=>'','datetime'=>'','firstName'=>'','lastName'=>'', 'image'=>'');
 $profile = get_user_by_id($id); 
 $profile->image = ( !empty($profile->image)    ? $profile->image    : 'blank.png' ); ;
 if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $Validate = new Validate();
  $error['email']     = $Validate->isEmail($email);
  $error['image']  = $Validate->isMediaUpload($files);
  $error['firstName']  = $Validate->isFirstName($forename);
  $error['lastName']  = $Validate->isLastName($surname);
  $valid = implode($error);
  if (strlen($valid) < 1 ) {

    $temporary   = $files_temp;
    $user = new User($id,$forename,$surname,$email,'', $files);
    $result = $user->update();
    if ($result) {
      //$destination = "/mnt/stor1-wc1-dfw1/387732/test1.phpandmysqlbook.com/web/content/phpsqlbook/uploads/" . $files;
      $destination = "c:\\xampp\htdocs\phpsqlbook\uploads\\" . $files;
      if (move_uploaded_file($temporary, $destination)) {
        $alert = '<div class="alert alert-success">File saved.</div>';
         header('Location: http://'.$_SERVER['HTTP_HOST'].'/phpsqlbook/cms/profile?id='.$id); 
      } else {  
    $alert = '<div class="alert alert-danger">File could not be saved.</div>';
      }  
    } 
  }
} 
get_HTML_template('header');
?>
<form class="login-form" method="post" enctype="multipart/form-data" action="/phpsqlbook/cms/profile?id=<?php echo $_SESSION["user_id"]; ?>" >
<fieldset>
  <legend>User Profile</legend>
  <div class="title-error"><?= $alert ?></div>
  <label>User Forename:
    <input name="Forename" type="text" value="<?= $profile->forename; ?>"  <?php if ($_SESSION["user_id"] != $profile->id) { ?> disabled <?php } ?> />
  </label>
  <span class="title-error"><?= $error['firstName']; ?></span><br />
  <label>User Surname:
    <input name="Surname" type="text" value="<?= $profile->surname; ?>"  <?php if ($_SESSION["user_id"] != $profile->id) { ?> disabled <?php } ?> />
  </label>
  <span class="title-error"><?= $error['lastName']; ?></span><br />
  <label>User Email:
    <input name="Email" type="text" value="<?= $profile->email; ?>"  <?php if ($_SESSION["user_id"] != $profile->id) { ?> disabled <?php } ?> />
  </label>
  <span class="title-error"><?= $error['email']; ?></span><br />
  <label>User Image:
    <img style="width:200px;" src="/phpsqlbook/uploads/<?= $profile->image; ?>"  <?php if ($_SESSION["user_id"] != $profile->id) { ?> disabled <?php } ?> />
  </label>
  <span class="title-error"><?= $error['image']; ?></span><br />
  <?php if ($_SESSION["user_id"] == $profile->id) { ?>
  <label>File:
    <input id="image" name="image" disabled type="text" value="<?= $profile->image; ?>" /></label>
  <br />
<input name="img" type="file"/><br /><br />
  <input name="Id" type="hidden" value="<?= $profile->id; ?>"/>
  <button type="submit" value="submit">Submit</button><br/><br/>
  <?php } ?>
  </fieldset>
</form> 
<?php
get_HTML_template('footer');
?>