<?php require_once('../includes/db_config.php');
include '../includes/header-register.php'; 
$error="";

function get_user_to_edit($dbHost, $userid) {
  $query = "select * FROM Users where user_id=:userid";
  $statement = $dbHost->prepare($query);
  $statement->bindParam(":userid", $userid);  
  $statement->execute();
  $statement->setFetchMode(PDO::FETCH_ASSOC); 
  return $statement;
}

function update_user($dbHost, $name, $email, $userid) {
 $error = "The user details were updated successfully";
 $query="UPDATE Users SET full_name= :name,email_address= :email where user_id= :userid";
  $statement = $dbHost->prepare($query);
  $statement->bindParam(":name", $name);  
  $statement->bindParam(":email", $email);  
 $statement->bindParam(":userid", $userid);  
  $statement->execute();
  if($statement->errorCode()!=0) {  
    $error = "The user details were not updated";
  } 
  return $error;
  
} 
 if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
    if (!empty($_POST["name"]) && !empty($_POST["email"])) { 
     $error = update_user($dbHost,$_POST["name"],$_POST["email"],'1001');
  } else { 
    $error = "<span class='red'>The name or email address was empty</span>";
  }
 }


$statement = get_user_to_edit($dbHost, '1001'); ?>
<form id="form1" class="indent" method="post" action="update-form.php">
   <?php while($row = $statement->fetch()) { ?>
         <h2>Edit User</h2>
         <label class="fieldheading">User Name:</label>
         <input name="name" type="text" value="<?php echo $row['full_name'];?>" />
         <label  class="fieldheading">User Email:</label>
         <input name="email" type="text" value="<?php echo $row['email_address']; ?>" />
         <input id="SaveButton" type="submit" name="submit" Value="Submit"  />     
    <?php  } ?>    
</form>
<?php echo $error; ?>
<?php require_once('../includes/footer-site.php'); ?>