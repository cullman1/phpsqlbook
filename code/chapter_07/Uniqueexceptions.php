<?php
/* Include passwords and login details */
require_once('../includes/db_config.php');

try {
   
  $query = "Insert into user (email) values ('bob@test.com')"; 
  $statement = $dbHost->prepare($query);
  $statement->execute(); 
}
catch (PDOException $e) {
  //Code continues here
  echo "An error has occurred: " . $e; 
}
?>
