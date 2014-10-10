<?php 
/* Include passwords and login details */
require_once('../includes/db_config.php');
 $num_rows = 0;
if (!empty($_REQUEST['emailAddress']))
{
    /* Query SQL Server for checking existing user. */
    $select_user_sql = "SELECT * from user WHERE email = '".$_REQUEST['emailAddress']."'";
    $select_user_result = $dbHost->prepare($select_user_sql);
    $select_user_result->execute();
    $select_user_result->setFetchMode(PDO::FETCH_ASSOC);
    $select_user_rows = $select_user_result->fetchAll();
    $num_rows = count($select_user_rows);
}

include '../includes/header-register.php' ?>
 <form id="register" name="register" method="post" action="emailcheck.php">
  <div class="wholeform">
      <div class="col-md-4"><h1>Check to see if email exists:</h1></div>
      <div class="col-md-4">
         <div class="form-group">
           <label for="emailAddress">Email address</label>
           <input type="email" class="form-control" id="emailAddress" name="emailAddress" placeholder="Enter email" required>
           <input type="hidden" name="submit_check" value="submit" />
         </div>
         <button type="submit" class="btn btn-default">Submit</button>
         <br/>  <br/>
          <div id="Status_Post">
              <?php
              if (($num_rows>0) && (!empty($_REQUEST['emailAddress'])))
              {
                  /* Already exists. */
                  echo "Email address exists";
              }	
              if (($num_rows==0) && (!empty($_REQUEST['emailAddress'])))
              {
                  /* Doesn't exist. */
                  echo "Email address doesn't exist";
              }
              ?>
         </div>
       </div>
   </div>
</form>
<?php include '../includes/footer-site.php' ?>

