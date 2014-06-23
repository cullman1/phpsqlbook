<?php

/* Include passwords and login details */
require_once('loginvariables.php');
  
/* Connect using MySql Authentication. */
$conn = mysql_connect( $serverName, $userName, $password);
if(!$conn)
{
        die("Unable to connect. Error: " . mysql_error());
}
  
/* Select db */
mysql_select_db($databaseName) or die ("Couldn't select db. Error:"  . mysql_error()); 

?>