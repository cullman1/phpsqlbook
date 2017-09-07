<?php
$_SESSION = array();
setcookie(session_name(),'', time()-3600, '/');
header('Location: /phpsqlbook/cms/index.php');
?>