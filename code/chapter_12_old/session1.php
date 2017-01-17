<?php
session_start();
$_SESSION["USER"] = "Hello";
echo $_SESSION["USER"];
?>
<a href="session2.php">Click here</a>
