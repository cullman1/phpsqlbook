<?php
session_start();
$_SESSION["name"] = "Chris";
echo "name".session_name()."<br>";
echo "id".session_id()."<br>";
?>
<a href="session1.php">Click here</a>