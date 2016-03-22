<?php 
include('../includes/db_config.php');
ini_set('display_errors', TRUE);
function get_Users($dbHost) {
try {
 $sql = "Select * from User";
 $statement = $dbHost->prepare($sql);
 $statement->execute();
 return $dbHost;
}
catch (PDOException $e) {
   if ($e->errorInfo[1] != 0) {
      echo $e->errorInfo[0]."<br/>";
      echo $e->errorInfo[1]."<br/>";
      echo $e->errorInfo[2]."<br/>";
    }
  }
}
$connection =get_Users($dbHost);
?>