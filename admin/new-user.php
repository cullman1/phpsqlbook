<?php 
require_once('authenticate.php'); 
  
/* Db Details */
require_once('../includes/db_config.php');

/* Query SQL Server for inserting data. */
$select_role_sql = "select role_id, role_name FROM role";
$select_role_result = $dbHost->query($select_role_sql);
# setting the fetch mode
$select_role_result->setFetchMode(PDO::FETCH_ASSOC);
include '../includes/header.php'; ?>
 <form id="form1" method="post" action="add-user.php?page=user">
      <div class="col-md-4"></div>
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
         <div class="form-group">
              <label for="uploader">Upload user image</label>
              <input type="file" id="uploader" name="uploader">
         </div>

        <input id="Role" name="Role" type="hidden" value="2" />              
         <button type="submit" class="btn btn-default">Create User</button>
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
       </form>
      </div>
    </div> <!-- /container -->
</form>
<?php include '../includes/footer.php' ?>