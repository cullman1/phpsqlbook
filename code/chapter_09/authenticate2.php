<?php
session_start();
if (!isset($_SESSION['authenticated']))
{
	  header('Location:/code/chapter_08/login/login2.php');
}
?>