<?php 
require_once('../classes/functions.php');
$alert  =   array('status' => '', 'message' =>'');
$error = array('id'=>'', 'title'=>'','article'=>'','template'=>'','email'=>'','password'=>'','mimetype'=>'','date'=>'','datetime'=>'','firstName'=>'','lastName'=>'', 'image'=>'');
 $profile_list = $this->connection->get_user_by_id($_GET["id"]); 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  require_once('../classes/validate.php');
  $Validate = new Validate();
  $this->error['email']     = $Validate->isEmail($_POST["Email"]);
  $this->error['image']  = $Validate->isMediaUpload($_FILES["img"]['tmp_name']);
  $this->error['firstName']  = $Validate->isFirstName($_POST["Forename"]);
  $this->error['lastName']  = $Validate->isLastName($_POST["Surname"]);
  $valid = implode($this->error);
  if (strlen($valid) < 1 ) {
    $alert = $this->connection->setProfile($_POST["Id"],$_POST["Forename"],$_POST["Surname"],$_POST["Email"],$_FILES["img"]["name"] ); 
    $temporary   = $_FILES["img"]['tmp_name'];
    $destination = "c:\\xampp\htdocs\phpsqlbook\uploads\\" . $_FILES['img']['name'];
    if (move_uploaded_file($temporary, $destination)) {
      $alert = array("status"=>"success","message"=> "File saved.");
    } else {
      $alert = array("status"=>"danger","message"=> "File could not be saved.");
    }
    header('Location: http://'.$_SERVER['HTTP_HOST'].'/phpsqlbook/profile/status?id='.$_POST["Id"]); 
  }
} 
?>
  <?php foreach ($profile_list as $profile) {  // Loop through categories ?>
<form method="post" action="/phpsqlbook/profile/update?id=<?= $profile->{'user.id'}; ?>" enctype="multipart/form-data">
  <h2>User Profile</h2>
  <div id="Status" style="color:red;" >
    <span class="<?= $alert['status']; ?>"><?= $alert['message']; ?></span>
  </div>
  <label>User Forename:
  <input name="Forename" type="text" value="<?= $profile->{'user.forename'}; ?>" /></label><span class="error"><?= $this->error['firstName']; ?></span><br /><br />
  <label>User Surname:
  <input name="Surname" type="text" value="<?= $profile->{'user.surname'}; ?>" /></label><span class="error"><?= $this->error['lastName']; ?></span><br /><br />
  <label>User Email:
  <input name="Email" type="text" value="<?= $profile->{'user.email'}; ?>" /></label><span class="error"><?= $this->error['email']; ?></span><br /><br />
  <label>User Image:
  <img src="/phpsqlbook/uploads/<?= $profile->{'user.image'}; ?>" /></label><span class="error"><?= $this->error['image']; ?></span><br /><br />
  <label>File:
  <input id="image" name="image" disabled type="text" value="<?= $profile->{'user.image'}; ?>" /></label><br /><br />
  <label><input name="img" type="file"/></label><br /><br />
  <input name="Id" type="hidden" value="<?= $profile->{'user.id'}; ?>"/>


  <button type="submit" value="submit" class="btn btn-default">Submit</button><br/><br/>
</form> 
  <?php } ?>
 <a href="/phpsqlbook/home">Return to Main Site</a>

