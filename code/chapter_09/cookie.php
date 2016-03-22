<?php 
 check_cookie($_COOKIE["UserName"], $_POST["name"], $_POST["remember_me"]);
  
  function check_cookie($cookie, $name, $rememberme) {  
  if (isset($cookie)) {
      echo "Hello ".$cookie.", welcome back to our site";
    } else {
      set_cookie($name, $rememberme);
    } 
  }
  
  function set_cookie($name, $rememberme) {
    if ($rememberme=="remember") {
       setcookie("UserName",$name,time()+604800,'/'); 
    }   
   if (!empty($name)) { 
      echo "Hello ".$name.", welcome to our site";
    }
  } 
?>
<form name="input_form" method="post" action="cookie.php">
  <?php if (!isset($_POST["name"]) && !isset($_COOKIE["UserName"]) ) { ?> 
    <label for="name">Full Name:</label> 
    <input type="text" name="name" /><br />
    <label for="remember_me">Remember Me?</label> 
    <input type="checkbox" name="remember_me" value="remember"/>
    <br/><input type="submit" name="submit" value="Submit"/>
  <?php } ?> 
</form>   