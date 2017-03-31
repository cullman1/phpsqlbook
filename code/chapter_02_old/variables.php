<?php
$username = 'Ivy';
$cost_per_pack = 5;
?>
<!DOCTYPE html>
<html>
<head>
<title>Variables</title>
<link rel="stylesheet" href="css/styles.css" />
</head>
<body>
<h1>Seeds</h1>
<p>Welcome <?php echo $username; ?></p>
<p>The cost of your seeds are
$<?php echo $cost_per_pack; ?> per pack.</p>
</body>
</html>