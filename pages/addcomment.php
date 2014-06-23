<?php
session_start();
if (!isset($_SESSION['authenticated']))
{
	  header('Location:../login/logon.php');

}
else
{
	header('Location:../pages/mainsite.php?showcomments='.$_REQUEST["articleid"]);
}

?>