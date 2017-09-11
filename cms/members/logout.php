<?php
require_once('../config.php');

$_SESSION = array(); 

$param = session_get_cookie_params();
setcookie(session_name(), '', time()-2400,
            $param['path'], $param['domain'],
            $param['secure'], $param['httponly']);

session_destroy();
      header('Location: '.ROOT .'index.php'); 
?>

