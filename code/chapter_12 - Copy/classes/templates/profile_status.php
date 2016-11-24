<?php 
$alert  =   array('status' => '', 'message' =>'');
$error = array('id'=>'', 'title'=>'','article'=>'','template'=>'','email'=>'','password'=>'','mimetype'=>'','date'=>'','datetime'=>'','firstName'=>'','lastName'=>'', 'image'=>'');
 $profile_list = $this->connection->get_user_by_id($_GET["id"]); 
?>
  <h2>User Profile</h2>
  <div id="Status" style="color:red;" >
    <span class="<?= $alert['status']; ?>"><?= $alert['message']; ?></span>
  </div>
    <?php foreach ($profile_list as $profile) {  // Loop through categories ?>
 <label class="fieldheading">Name: </label><?= $profile->{'user.forename'}; ?> <?= $profile->{'user.surname'}; ?><br/><br/>
 <label class="fieldheading">Image: </label><img src="/phpsqlbook/uploads/<?= $profile->{'user.image'}; ?>" /> <br/><br/>
 <label class="fieldheading">Email: </label><?= $profile->{'user.email'}; ?><br/><br/>
   <?php } ?>
 <br /><br/><a href="/phpsqlbook/home/">Return to Main Site</a>
</div>  
