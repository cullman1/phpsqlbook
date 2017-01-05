<?php
session_start();
if (isset($_SESSION["login"])) { 
  if (empty($_SESSION["login"])) { 
    header('Location:/phpsqlbook/login/');
  }
} else {
  header('Location:/phpsqlbook/login/');   
}
                 //  $user_object = unserialize($so);
             //   $auth = $user_object->getAuthenticated();
?>

           