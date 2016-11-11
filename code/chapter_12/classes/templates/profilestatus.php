<?php 
$alert  =   array('status' => '', 'message' =>'');
?>
  <h2>User Profile</h2>
  <div id="Status" style="color:red;" >
    <span class="<?= $alert['status']; ?>"><?= $alert['message']; ?></span>
  </div>
 <label class="fieldheading">Name: </label>{{user.forename}} {{user.surname}}<br/><br/>
 <label class="fieldheading">Image: </label><img src="/phpsqlbook/uploads/{{user.image}}" /> <br/><br/>
 <label class="fieldheading">Email: </label>{{user.email}}<br/><br/>

 <br /><br/><a href="/phpsqlbook/home/">Return to Main Site</a>
</div>  
