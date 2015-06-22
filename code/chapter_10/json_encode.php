<?php
$user = array(101,'Morton Walsh','morton@acme.org',);
echo json_encode($user);
echo "<br/><br/>";
$user = array('id' => 101,'name' => 'Morton Walsh', 'email' => 'morton@acme.org',);
echo json_encode($user, JSON_FORCE_OBJECT );
?>