<?php
session_start();
$_SESSION = array();
setcookie(session_name(),'', time()-3600, '/');
session_destroy();
header('Location: /phpsqlbook/cms/index.php');
?>