<?php 
/* Include passwords and login details */
require_once('../includes/db_config.php');

include '../includes/header-register.php';

if (!empty($_REQUEST['password']) && !empty($_REQUEST['firstName']) && !empty($_REQUEST['lastName']) && !empty($_REQUEST['emailAddress']) )
{
    /* Query SQL Server for checking existing user. */
    $select_user_sql = "SELECT * from user WHERE email = '".$_REQUEST['emailAddress']."'";
    $select_user_result = $dbHost->prepare($select_user_sql);
    $select_user_result->execute();
    $select_user_result->setFetchMode(PDO::FETCH_ASSOC);
    $select_user_rows = $select_user_result->fetchAll();
    $num_rows = count($select_user_rows);
	    if($num_rows>0)
	    {
			/* User exists */
            echo "User already exists";
	    }	
	    else
	    {
		    /* Query SQL Server for inserting new user. */
		    $insert_user_sql = "INSERT INTO user (full_name, password, email, role_id, date_joined, , active) VALUES ('".$_REQUEST['firstName']." ".$_REQUEST['lastName']."', '".$passwordToken."', '".$_REQUEST['emailAddress']."','".$_REQUEST['Role']."', '". date("Y-m-d H:i:s") ."', 0)";
            $insert_user_result = $dbHost->prepare($insert_user_sql);
            $insert_user_result->execute();
		    if($insert_user_result->errorCode()!=0) 
            {  
                /* Insert failed */
                echo "User registration failed";
            }
		    else
		    {
  			    /* Insert succeeded */
                  echo "User registration succeeded";
	        }
	    }
    
}

?>

 <form id="form1" method="post" action="register2.php">
  <div class="wholeform">
      <div class="col-md-4"><h1>Please register:</h1></div>
      <div class="col-md-4">
               <div class="form-group">
           <label for="emailAddress">Email address</label>
           <input type="email" class="form-control" id="emailAddress" name="emailAddress" placeholder="Enter email">
         </div>
         <div class="form-group">
           <label for="firstName">First name</label>
           <input type="text" class="form-control" id="firstName" name="firstName" placeholder="First name">
         </div>
         <div class="form-group">
           <label for="lastName">Last name</label>
           <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Last name">
         </div>
         <div class="form-group">
           <label for="password">Password</label>
           <input type="password" class="form-control" id="password" name="password" placeholder="Password">
         </div>
        <input id="Role" name="Role" type="hidden" value="2">
              
         <button type="submit" class="btn btn-default">Register</button>
         <br/>  <br/>
          <div id="Status_Post">  
         </div>
             </div>
      </div>
</form>
<?php include '../includes/footer-site.php' ?>