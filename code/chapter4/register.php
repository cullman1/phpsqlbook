<!DOCTYPE html>
<html>
  <head><title>Register</title></head>
  <body>
    <h1>Registration</h1>

<?php
  if (isset($_POST['submit'])) {

    $email    = $_POST["email"];
    $pwd      = $_POST["password"];
//    $regex    = "/[a-zA-Z]/";
    $regex    = "/^[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+.[a-zA-Z0-9-.]+$/";

    if (!preg_match($regex, $email)) {
      echo 'email bad';
      echo $email;
    } else {
      echo 'email good';
      echo $email;
    }

?><br><?php

    function password_strength($password) {
      $check1 = '/[A-Z]/';  // Uppercase
      $check2 = '/[a-z]/';  // Lowercase
      $check3 = '/[0-9]/';  // Numbers

      if(preg_match_all($check1, $password, $o)<2) return FALSE;
      if(preg_match_all($check2, $password, $o)<2) return FALSE;
      if(preg_match_all($check3, $password, $o)<2) return FALSE;
      if(strlen($password)<8) return FALSE;

      return TRUE;
    }

    if (!password_strength($pwd)){
      echo 'pwd bad';
      echo $pwd;
    } else {
      echo 'pwd good';
      echo $pwd;
    }


  }
?>

  </body>
</html>