<?php
  include('../includes/db_config.php');
require_once('../classes/user_static.php');
 include '../includes/header.php';

  $_SESSION["Count"] = Login::getCount($dbHost);
    if (isset($_SERVER['REQUEST_METHOD']) && isset($_POST["hid"])) {
    echo "here";
     Login::setCount($dbHost,$_SESSION["Count"]+1);  
    }

 ?>
 <form method="post" action="static_wrong.php">
  <?php echo "Logins:" .$_SESSION["Count"]. "<br/>"; ?>    
         <button type="submit" class="btn btn-default">Click to Login</button><br/>  <br/>   
<input id="hid" name="hid" value=1" type="hidden"/>  
       </form>
<?php include '../includes/footer.php' ?>