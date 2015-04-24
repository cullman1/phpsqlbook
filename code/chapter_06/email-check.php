<?php require_once('../includes/db_config.php');
      $num_rows = 0;
      if (!empty($_POST['email'])) {
          $sel_user_sql = "SELECT * from user WHERE email = '".$_POST['email']."'";
          $sel_user_set = $dbHost->prepare($sel_user_sql);
          $sel_user_set->execute();
          $sel_user_rows = $sel_user_set->fetchAll();
          $num_rows = count($sel_user_rows);
      } 
      include '../includes/header-register.php'; ?>
<form id="register" name="register" method="post" action="email-check.php">
   <div class="indent">
      <h1>Check to see if email exists</h1>
      <div class="form-group">
         <label for="email">Email address</label>
         <input type="email" name="email" placeholder="Enter email">
      </div>
      <input type="submit" class="button_block btn btn-default" value="Submit">
      <div id="Status_Post">
         <?php if (($num_rows>0) && (!empty($_POST['email']))) {
            echo "Email address exists";
         } else if (($num_rows==0) && (!empty($_POST['email']))) {
            echo "Email address doesn't exist";
         } else if ((isset($_POST['email']))) {
            echo "Email field must contain a value";
         } ?>
      </div>
   </div>
</form>
<?php include '../includes/footer-site.php'; ?>
