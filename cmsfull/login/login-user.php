<?php  
/* Include passwords and login details */
error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', TRUE);
require('../classes/configuration.php');
require('../classes/registry.php');
require_once('../classes/user.php');
session_start();

//Registy create instance of
$registry = Registry::instance();

//Database
$registry->set('configfile', new Configuration());
$db = $registry->get('configfile');
$conn="mysql:host=".$db->getServerName().";dbname=".$db->getDatabaseName();
$pdo = new PDO($conn,$db->getUserName(),$db->getPassword()); 
$pdo->setAttribute(PDO::ATTR_FETCH_TABLE_NAMES, true);
$registry->set('pdo', $pdo);
$dbHost =  $registry->get('pdo');
  
/* Query SQL Server for checking user details. */
if(isset($_REQUEST['password'])) {
    $passwordToken = sha1($db->getPreSalt() . $_REQUEST['password'] . $db->getAfterSalt());
    $query = "SELECT Count(*) as CorrectDetails, user_id, full_name, email from user WHERE email ='".$_REQUEST['emailAddress']."' AND password= '".$passwordToken."'" ." AND active= 0";
    $statement = $dbHost->prepare($query);
    $statement->execute();
    $statement->setFetchMode(PDO::FETCH_BOTH);

    /* Redirect to original page */
    while($select_user_row = $statement->fetch()) {
        if ($select_user_row[0]==1) {      
            $user_object = new User( $select_user_row[2],$select_user_row[3],$select_user_row[1]);
            $s =serialize($user_object); 
            $_SESSION["user2"] = $s;
            echo  $_SESSION["user2"];
            header('Location:../recipes');       
        } else {
            /* Incorrect details */
			header('Location:../login/login-user.php?login=failed');
        }
    }
} ?>
 <form id="form1" method="post" action="login-user.php">
       <div class="wholeform">
         <br/>
      <div class="col-md-4"><h1>Please login:</div>
      <div class="col-md-4">
         <div class="form-group">
           <label for="emailAddress">Email address</label>
           <input type="email" class="form-control" id="emailAddress" name="emailAddress" placeholder="Enter email">
         </div>
         <div class="form-group">
           <label for="password">Password</label>
           <input type="password" class="form-control" id="password" name="password" placeholder="Password">
         </div>
         <button type="submit" class="btn btn-default">Login</button>
         <br/>
         <br/>
          <div id="Status" ><?php     if(isset($_REQUEST['login'])) {
    echo "<br/><span class='red'>Login failed</span>";
    }    ?></div>
  </div>
 </div>
</form>

