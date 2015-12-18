<?php 
include '../../classes/user.php';
ini_set('display_errors', TRUE);
function valid($name,$password,$authenticated) {
 try {
    
    $user = new User($name,$password, $authenticated);
    $user->setAuthenticated($name,$password);
    echo "Just fine";
 }
  catch (InvalidArgumentException $e) {
   echo "Value is incorrect";
 }
 catch (BadMethodCallException $e) {
  echo "Method doesn't exist";
 }
  catch (Exception $e) {
  echo "General Exception";
 }
}
valid("Morton Walsh", "Test1", "Test");
?>