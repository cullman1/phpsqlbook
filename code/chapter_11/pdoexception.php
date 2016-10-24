<?php 
include('../includes/database_connection.php');
ini_set('display_errors', '1');

function get_Users() {
  $users = '';
  try {
    $query = "SELECT * FROM users";
    $statement = $GLOBALS['connection']->prepare($query);
    $statement->execute();
    $users =   $statement->fetch(PDO::FETCH_OBJ);
  }
  catch (PDOException $e) {
    if ($e->errorInfo[1] != 0) {
      echo "SQL Error code: " . $e->errorInfo[0]."<br/>";
      echo "PDO Error code: " .$e->errorInfo[1]."<br/>";
      echo "PDO Error message: " .$e->errorInfo[2]."<br/>";
    }
  }
  return ($users ? $users : false);}
$returned_users =get_Users();
if ($returned_users) {
  echo "Query worked";
}
?>