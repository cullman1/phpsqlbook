<?php 
require_once('authenticate.php'); 
error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', TRUE);
  
/* Db Details */
require_once('../includes/db_config.php');

/* Query SQL Server for inserting data. */
$tsql = "select role_id, role_name FROM 387732_phpbook1.role";
$stmt = mysql_query($tsql);
if(!$stmt)
{  
    /* Error Message */
    die("Query failed: ". mysql_error());
}

?>
<?php include '../includes/header.php' ?>
 <form id="form1" method="post" action="adduser.php?page=admin">
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
<label for="password">Role</label>
                <select id="Role" name="Role">
              
                 <?php while($row = mysql_fetch_array($stmt)) { ?>
                <option value="<?php  echo $row['role_id']; ?>"><?php  echo $row['role_name']; ?></option>
                  <?php } ?> 
                  </select>
             </div>

  <div class="form-group">
              <label for="uploader">Upload user image</label>
              <input type="file" id="uploader" name="uploader">
         </div>

         <button type="submit" class="btn btn-default">Create User</button>
          <br/>  <br/>
          <div id="Status_Post">
            <?php 
             if(isset($_GET['submitted']))
             {
              if($_GET['submitted']=="true")
              {
                echo "<span class='red' style='color:red;'>User successfully registered!</span>";
              }
              else if($_GET['submitted']=="false")
              {
                echo "<span class='red' style='color:red;'>A user with that email address has already been registered! Please either login or use a different password.</span>";
              }
              else if($_GET['submitted']=="missing")
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