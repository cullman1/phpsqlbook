<?php
session_start();
if (!isset($_SESSION['authenticated']))
{
      header('Location:../chapter7/login-admin.php');
}
?>