<?php 
require_once('../../classes/functions.php');
$alert  =   array('status' => '', 'message' =>'');
$error = array('id'=>'', 'title'=>'','article'=>'','template'=>'','email'=>'','password'=>'','mimetype'=>'','date'=>'','datetime'=>'','firstName'=>'','lastName'=>'', 'image'=>'');
?>
<form method="POST" action="/phpsqlbook/profile/update?id={{user.id}}" enctype="multipart/form-data">
  <h2>User Profile</h2>
  <div id="Status" style="color:red;" >
    <span class="<?= $alert['status']; ?>"><?= $alert['message']; ?></span>
  </div>
  <label>User Forename:
  <input name="Forename" type="text" value="{{user.forename}}" /></label><span class="error"><?= $error['firstName']; ?></span><br /><br />
  <label>User Surname:
  <input name="Surname" type="text" value="{{user.surname}}" /></label><span class="error"><?= $error['lastName']; ?></span><br /><br />
  <label>User Email:
  <input name="Email" type="text" value="{{user.email}}" /></label><span class="error"><?= $error['email']; ?></span><br /><br />
  <label>User Image:
  <img src="/phpsqlbook/uploads/{{user.image}}" /></label><span class="error"><?= $error['image']; ?></span><br /><br />
  <label>File:
  <input id="image" name="image" disabled type="text" value="{{user.image}}" /></label><br /><br />
  <label><input name="img" type="file"/></label><br /><br />
  <input name="Id" type="hidden" value="{{user.id}}"/>
  <button type="submit" class="btn btn-default">Submit</button><br/><br/>
</form> 
 <a href="/phpsqlbook/home">Return to Main Site</a>

