<?php
session_start();
if (!isset($_SESSION['authenticated']))
{
	  header('Location:/code/chapter_09/login/login.php');
}
?>