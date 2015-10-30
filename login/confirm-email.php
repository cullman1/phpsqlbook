<?php require_once('../includes/db_config.php');
function get_user($dbHost,$userid) { 
  $query="SELECT * FROM user WHERE user_id =:userid";
  $statement = $dbHost->prepare($query); 
  $statement->bindParam(":userid", $userid);            
  $statement->execute();
  return $statement;
} 

function make_user_active($dbHost,$userid) { 
  $query="UPDATE user set active=1 WHERE user_id =:userid";
  $statement = $dbHost->prepare($query); 
  $statement->bindParam(":userid", $userid);            
  $statement->execute();
} 

if (isset($_GET["userid"])) {
  $user = get_user($dbHost,$_GET["userid"]));
  if ($user["active"]=="0") {
    make_user_active($dbHost,$_GET["userid"]);
    echo "Thank you for confirming your email, your account   
    is now active";
  }
} else {
  echo "An error has occurred with confirmation.";
} ?>
