<?php
session_start();
$_SESSION["name"] = "Chris";
echo "name".session_name()."<br>";
echo "id".session_id()."<br>";
$hash = password_hash("password",656565);
echo $hash;
?>
<a href="session1.php">Click here</a>