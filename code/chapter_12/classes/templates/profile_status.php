<?php 
$alert  =   array('status' => '', 'message' =>'');
$error = array('id'=>'', 'title'=>'','article'=>'','template'=>'','email'=>'','password'=>'','mimetype'=>'','date'=>'','datetime'=>'','firstName'=>'','lastName'=>'', 'image'=>'');
$profile = getUserById($this->connection,$_GET["id"]); 
?>
  <h2>User Profile</h2>
  <div id="Status" style="color:red; display:none;" >
    <span class="<?= $alert['status']; ?>"><?= $alert['message']; ?></span>
  </div>
 <label class="fieldheading">Name: </label><?= $profile->{'user.forename'}; ?> <?= $profile->{'user.surname'}; ?><br/><br/>
 <label class="fieldheading">Image: </label><img src="/phpsqlbook/uploads/<?= $profile->{'user.image'}; ?>" /> <br/><br/>
 <label class="fieldheading">Email: </label><?= $profile->{'user.email'}; ?><br/><br/>
 <br /><br/><a href="/phpsqlbook/home/">Return to Main Site</a>
</div>  