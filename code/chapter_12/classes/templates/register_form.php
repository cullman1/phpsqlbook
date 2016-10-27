 <form id="form1" method="post" action="<?php echo "http://".$_SERVER['HTTP_HOST']; ?>/cmsfull/register/add/1">
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
                 if($_REQUEST['submitted']=="true")
              {
                echo "<span class='red' style='color:red;'>User successfully registered!</span>";
              }
                else if($_REQUEST['submitted']=="false")
              {
                echo "<span class='red' style='color:red;'>A user with that email address has already been registered! Please either login or use a different password.</span>";
              }
              else if($_REQUEST['submitted']=="missing")
              {
                echo "<span class='red' style='color:red;'>You haven't filled in all of the fields!</span>";
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
