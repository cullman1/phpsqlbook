<?php 
$now     = new DateTime();
$expires = new DateTime('2017-03-30 23:59');
if ($expires < $now) {
    header('Location: expired.php');
    exit();
}
?>
<!DOCTYPE html> 
<html>...
<h1>Discount code:</h1>
<p>Your discount code for 017-31-03</p>