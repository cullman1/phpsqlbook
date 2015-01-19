<?php
session_start();
if (!isset($_SESSION['authenticated']))
{
	  header('Location:../chapter6/login-admin2.php');
}
?>