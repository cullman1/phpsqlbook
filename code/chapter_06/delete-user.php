<?php require_once('../includes/db_config.php');
if (isset($_POST["delete-button"])) {
	$del_user_sql = "delete from user where log_in_number<1";
	$del_user_set = $dbHost->prepare($del_user_sql);
	$del_user_set->execute();
}
if (isset($_POST["insert-button"])) {
    $ins_user_sql = "insert into user (email, date_joined, full_name, log_in_number) values ('test@test.com', '2015-04-21 12:00:00:AM', 'Test User', 0)";
$ins_user_set = $dbHost->prepare($ins_user_sql);
$ins_user_set->execute();
}
$sel_user_sql = "select * from user where !(log_in_number is null) order by log_in_number desc";
$sel_user_set = $dbHost->prepare($sel_user_sql);
$sel_user_set->execute(); ?>
<form id="form1" class="indent" method="post" action="delete-user.php">
    <table>
        <tr><td>Name</td><td>Email</td><td>Total Log Ins</td></tr>
   <?php while($sel_user_row = $sel_user_set->fetch()) { ?>
  <tr><td><?php echo $sel_user_row["full_name"]; ?> </td><td><?php echo $sel_user_row["email"]; ?> </td><td><?php echo $sel_user_row["log_in_number"]; ?> </td></tr>
   <?php } ?> 
        </table>
   <div id="col-md-4">
       <input type="submit" name="delete-button" Value="delete"  />            
       <input type="submit" name="insert-button" Value="insert"  />
   </div>   
</form>
