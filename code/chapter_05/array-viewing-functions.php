<!DOCTYPE html>
<html>
<head>
  <title>Built-in functions, objects and arrays</title>
  <link rel="stylesheet" href="css/styles.css" />
</head>
<body>
<?php
  $user = array('name'   => 'Ivy',
                 'age'    => 10,
                 'member' => TRUE);
?>

<h1>print_r()</h1>
<?php print_r($user); ?>

<h1>var_dump()</h1>
<?php var_dump($user); ?>
</body>
</html>