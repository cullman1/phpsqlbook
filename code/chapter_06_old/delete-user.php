<?php require_once('../includes/db_config.php');
function delete_user($dbHost) {
 $query = "delete from user where log_in_number<1";
  $statement = $dbHost->prepare($query);
  $statement->execute();
}
function insert_user($dbHost) {
 $query = "insert into user (email, date_joined, full_name, log_in_number) values ('test@test.com', '2015-04-21 12:00:00:AM', 'Test User', 0)";
  $statement = $dbHost->prepare($query);
  $statement->execute();
}
function select_users($dbHost) {
 $query="select * from user where !(log_in_number is null)";
 $statement = $dbHost->prepare($query);
 $statement->execute();
 return $statement;
}
 if (isset($_POST["delete-btn"])) {
  delete_user($dbHost);
}
if (isset($_POST["insert-btn"])) {
  insert_user($dbHost);
}
$statement = select_users($dbHost); ?>
<form class="indent" method="post" action="delete-user.php">
 <table>
  <tr><td>Name</td><td>Email</td><td>Total Log Ins</td></tr>
  <?php while($row = $statement->fetch()) { ?>
   <tr><td><?php echo $row["full_name"]; ?></td>
   <td><?php echo $row["email"]; ?></td>
   <td><?php echo $row["log_in_number"]; ?> </td></tr>
  <?php } ?> 
 </table>
<input type="submit" name="delete-btn" Value="delete" />           
<input type="submit" name="insert-btn" Value="insert" /> 
</form>
