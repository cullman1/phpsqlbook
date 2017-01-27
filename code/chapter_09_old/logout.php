<?php 
require_once('functions.php');

logout_user();
header('Location: login.php');
?>