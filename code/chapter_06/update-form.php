<?php require_once('../includes/db_config.php');
include '../includes/header-register.php'; 
$sel_user_sql = "select * FROM Users where user_id=1001";
$sel_user_set = $dbHost->prepare($sel_user_sql);
$sel_user_set->execute();
$sel_user_set->setFetchMode(PDO::FETCH_ASSOC); ?>
<form id="form1" class="indent" method="post" action="submit-user.php">
   <?php while($sel_user_row = $sel_user_set->fetch()) { ?>
      <div id="col-md-4">
         <h2>Edit User</h2>
         <label class="fieldheading">User Name:</label>
         <input name="name" type="text" value="<?php echo $sel_user_row['full_name'];?>" />
         <label  class="fieldheading">User Email:</label>
         <input name="email" type="text" value="<?php echo $sel_user_row['email_address']; ?>" />
         <input id="SaveButton" type="submit" name="submit" Value="Submit"  />
         <input id="userid" name="userid" type="hidden" value="1001" />
         <div id="Status" class="status_block">
            <?php if(isset($_REQUEST['submitted'])) {
               echo "<span class='red'>User successfully edited</span>";
            } ?>
         </div>
      </div>
   <?php } ?>    
</form>
<?php require_once('../includes/footer-site.php'); ?>