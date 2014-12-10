<?php  
/* Include passwords and login details */
require_once('../includes/db_config.php');
require_once('../classes/user.php');

/* Query SQL Server for checking user details. */
$passwordToken = sha1($preSalt . $_REQUEST['password'] . $afterSalt);
$select_user_sql = "SELECT Count(*) as CorrectDetails, user_id, full_name, email from user WHERE email ='".$_REQUEST['emailAddress']."' AND password= '".$passwordToken."'" ." AND active= 0";
$select_user_result = $dbHost->prepare($select_user_sql);
$select_user_result->execute();
$select_user_result->setFetchMode(PDO::FETCH_ASSOC);

  	/* Redirect to original page */
while($select_user_row = $select_user_result->fetch())
  	{
        if ($select_user_row["CorrectDetails"]==1)
  	 	{
  	 		session_start();
  	 		/* store user_id */
               
            $user_object = new User( $select_user_row["full_name"],  $select_user_row["email"], $select_user_row["user_id"] ); 
  	 		//$_SESSION['authenticated'] = $select_user_row["user_id"];
            //$_SESSION['username'] = $select_user_row["full_name"];
            //$_SESSION['email'] = $select_user_row["email"];
          
            /* serialize */
            $s =serialize($user_object);
            $_SESSION["user"] = $s;
        
            if(isset($_REQUEST["page"]))
            {
                
                if ($_REQUEST["page"]=="pages")
                {
                    header('Location:../admin/pages.php');
                }
                if ($_REQUEST["page"]=="mainsite")
                {
                    header('Location:../home?showcomments=true');
  	 	        }
                if ($_REQUEST["page"]=="example") {				header('Location:../code/chapter6/links.php');						 	        }     
            }
            else
            {
                header('Location:../home');
            }
        }
  	 	else
  	 	{
  	 		/* Incorrect details */
			header('Location:../login/logon.php?login=failed');
  	 	}
    }

?>