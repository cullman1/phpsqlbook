<?php 
require_once('authenticate2.php'); 

/* Include passwords and login details */
require_once('../includes/db_config.php');
include '../includes/header.php';

function get_role($dbHost, $email) {
 $query = "SELECT * from user WHERE email = :email";
 $statement = $dbHost->prepare($query);
 $statement->bindParam(":email", $email);
 $statement->execute();
 $statement->setFetchMode(PDO::FETCH_ASSOC);
 while ($row = $statement->fetch()) {
  return $row["role_id"];
 }
 return "1";
}

$role = get_role($dbHost, $_SESSION["email"]); 
echo "<br/><a href='#'>Link 1</a>";
echo "<br/><a href='#'>Link 2</a>";
if ($role=="1") {
 echo"<br/><a href='#' '>Admin Link 3</a>";
 echo"<br/><a href='#' '>Admin Link 4</a>";
} 

include '../includes/footer.php';
?>