<?php include '../includes/header-register.php' ?>

 <form id="form1" method="post" action="../admin/add-user.php?page=register">
  <div class="wholeform">
  <br/>
      <div class="col-md-4"><h1>Please register:</h1></div>
      <div class="col-md-4">
        <form role="form">
         <div class="form-group">
           <label for="emailAddress">Email address</label>
           <input type="email" class="form-control" id="emailAddress" name="emailAddress" placeholder="Enter email">
         </div>
         <div class="form-group">
           <label for="firstName">First name</label>
           <input type="text" class="form-control" id="firstName" name="firstName" placeholder="First name">
         </div>
         <div class="form-group">
           <label for="lastName">Last name</label>
           <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Last name">
         </div>
         <div class="form-group">
           <label for="password">Password</label>
           <input type="password" class="form-control" id="password" name="password" placeholder="Password">
         </div>


        <input id="Role" name="Role" type="hidden" value="2">
              
         <button type="submit" class="btn btn-default">Register</button>
         <br/>  <br/>
          <div id="Status_Post">
            <?php 
             if(isset($_REQUEST['submitted']))
             {
                 switch($error)
                 {
                     case 0:
                         echo "<span class='red' style='color:red;'>User successfully registered!</span>";
                         break;
                     case 1:
                         echo "<span class='red' style='color:red;'>A user with that email address has already been registered! Please either login or use a different password.</span>";
                         break;
                     case 2:      
                         echo "<span class='red' style='color:red;'>You haven't filled in all of the fields!</span>";
                         break;
                     case 3:      
                         echo "<span class='red' style='color:red;'>Your password must contain at least one alphanumeric, one digit and one non-alpha-numeric character</span>";
                         break;
                 }    
             }  
           ?>
         </div>
             </div>
       </form>
         <br/>
      </div>

    </div> <!-- /container -->

</form>

<?php include '../includes/footer-site.php' ?>