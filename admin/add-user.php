<?php 
/* Include passwords and login details */
require_once('../includes/db_config.php');

if (empty($_REQUEST['password']) || empty($_REQUEST['firstName']) || empty($_REQUEST['lastName']) || empty($_REQUEST['emailAddress']) )
{
	/* Redirect to original page */
  	$name = $_REQUEST['page'];
  	if($name=="register")
  	{
  		header('Location:../login/'.$name.'.php?submitted=missing');
  	}
  	else
  	{
    	header('Location:new-'.$name.'.php?submitted=missing');
	}
}
else
{
    /* Hash password */
    $passwordToken = sha1($preSalt . $_REQUEST['password'] . $afterSalt);

    /* Query SQL Server for checking existing user. */
    $select_user_sql = "SELECT * from user WHERE email = '".$_REQUEST['emailAddress']."'";
    $select_user_result = $dbHost->query($select_user_sql);
# setting the fetch mode
$select_user_result->setFetchMode(PDO::FETCH_ASSOC);
	    if(mysql_num_rows($select_user_result)>0)
	    {
			/* Redirect to original page */
  		    $name = $_REQUEST['page'];
      
  		    if($name=="register")
  		    {
			    header('Location:../login/'.$name.'.php?submitted=false');
  		    }
  		    else
  		    {
    		    header('Location:new-'.$name.'.php?submitted=false');
		    }
	    }	
	    else
	    {
		    /* Query SQL Server for inserting new user. */
            $name="";
            if(isset($_FILES['uploader']))
            {
                $name = $_FILES["uploader"]["name"];
                move_uploaded_file($_FILES['uploader']['tmp_name'], $folder);
            }

            /* Query SQL Server for inserting new user. */
		    $insert_user_sql = "INSERT INTO user (full_name, password, email, role_id, date_joined, user_image) VALUES ('".$_REQUEST['firstName']." ".$_REQUEST['lastName']."', '".$passwordToken."', '".$_REQUEST['emailAddress']."','".$_REQUEST['Role']."', '". date("Y-m-d H:i:s") ."', '". $name ."')";
	
            $insert_user_result = $dbHost->query($insert_user_sql);
		    if(!$insert_user_result) {  die("Query failed: ". mysql_error()); }
		    else
		    {
  			    /* Redirect to original page */
  			    $name = $_REQUEST['page'];
  			    if($name=="register")
  			    {
  				    header('Location:../login/'.$name.'.php?submitted=true');
  			    }
  			    else
  			    {
    			    header('Location:'.$name.'.php?submitted=true');
			    }
	        }
	    }
    
}
?>