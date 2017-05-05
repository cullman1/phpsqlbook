<?php
  $visited  = filter_input(INPUT_COOKIE, 'visited');
  if ($visited==TRUE) {
  $greeting = 'Welcome back';

  } else {
        setcookie('visited', TRUE);
    $greeting = 'Welcome';
  }
?>
<h1><?= $greeting; ?></h1>