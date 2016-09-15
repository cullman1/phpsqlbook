<?php
session_start();
if (!isset($_SESSION['authenticated']))
{
	  header('Location:../login/login.php');
}
?>