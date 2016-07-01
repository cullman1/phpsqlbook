<?php   require_once('includes/database_connection.php'); 

 $id  = ( isset($_GET['id'])  ? $_REQUEST['id']  : '' ); 
function get_user_by_id($userid) { 
  $query="SELECT * FROM user WHERE user_id =:id";
  $statement = $GLOBALS['connection']->prepare($query);
  $statement->bindParam(":id", $userid);
  $statement->execute();
  return $statement;
} 
function make_user_active($userid) { 
  $query="UPDATE user set active=1 WHERE user_id =:id";
  $statement = $GLOBALS['connection']->prepare($query);
  $statement->bindParam(":id", $userid);
  $statement->execute();
} 
if (!isempty($id)) { 
  $user = get_user_by_id($id);
    if ($user->active=="0") {
      make_user_active($id);
      echo "Thanks for confirming your email, your account is now active";
    }
} else {
  echo "An error has occurred with confirmation.";
} ?>