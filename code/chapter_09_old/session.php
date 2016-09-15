<?php 
 session_start();
function create_session() {

 $_SESSION['authenticated'] = "abc12356";
 $_SESSION['username'] = "Chris";
 $_SESSION['email'] = "chris@test.com";

} 

 create_session();
if($_SERVER['REQUEST_METHOD'] == 'POST') {
//unset($_SESSION['email']); 	
//session_unset();
session_destroy();
 echo "SESSIONS" . $_SESSION['authenticated'] . "<br/>" . $_SESSION['username'] . "<br/>" . $_SESSION['email'];
 if (isset($_SESSION['authenticated'])) {
  echo "session auth still set";
 }

} ?>
<form method="post" action="session.php">
  <h1>Please press:</h1>
  <br><button type="submit">Login</button>    
</form>