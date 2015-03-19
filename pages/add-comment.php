<?php
session_start();
if (!isset($_SESSION["user2"])) 
{
	  header('Location:../login/logon.php');
}
else
{
	header('Location:../pages/main.php?showcomments='.$_REQUEST["articleid"]);
}

?>