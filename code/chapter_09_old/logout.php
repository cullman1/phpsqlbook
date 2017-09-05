<?php 
require_once('../includes/functions.php');

logout_user();
header('Location: login.php');
?>