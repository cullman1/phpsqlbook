<?php
session_start();
if (!isset($_SESSION['authenticated']))
{
	  header('Location:../chapter6/login-user.php');
}
else
{
	header('Location:../chapter6/commenting.php?showcomments='.$_REQUEST["articleid"]);
}

?>