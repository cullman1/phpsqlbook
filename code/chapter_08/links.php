<?php 
require_once('authenticate.php'); 

/* Include passwords and login details */
require_once('../includes/db_config.php');
include '../includes/header-register.php';

function get_role($email) {
 $query = "SELECT * from user WHERE email =:email";
 $statement = $dbHost->prepare($query);
 $statement->bindParam(":email", $email);
 $statement->execute();
 $statement->setFetchMode(PDO::FETCH_ASSOC);
 if ($row = $statement->fetch()) {
  return $row["role_id"];
 }
 return "1";
}

$role = get_role($_SESSIONS["email"]); 
echo "<br/><a href='#'>Link 1</a>";
echo "<br/><a href='#'>Link 2</a>";
if ($row=="2") {
 echo"<br/><a href='#'>Admin Link 3</a>";
 echo"<br/><a href='#'>Admin Link 4</a>";
} ?>

include '../includes/footer.php';
?>