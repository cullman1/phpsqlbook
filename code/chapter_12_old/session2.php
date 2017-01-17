<?php
session_start();

echo "SESSION:". $_SESSION["USER"];
echo "<br/>SESSION2:". $_SESSION["user2"];
?>
<a href="session1.php">Click here</a>
