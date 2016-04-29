<?php 
  function check_cookie($cookie, $name, $rememberme) {  
    if (isset($cookie)) {
      return 'Hello '.$cookie.', welcome back to our site';
    } else {
      $message = set_cookie($name, $rememberme);
      return $message;
    } 
  }
  
  function set_cookie($name, $rememberme) {
    if ($rememberme=="remember") {
       setcookie("UserName",$name,time()+604800,'/'); 
    }   
   if (!empty($name)) { 
      return "Hello ".$name.", welcome to our site";
    } else {
      return '';
}
  } 

echo check_cookie($_COOKIE["UserName"], $_POST["name"], $_POST["remember_me"]); 
?>

<form name="input_form" method="post" action="cookie.php">
  <?php if (!isset($_POST["name"]) && !isset($_COOKIE["UserName"]) ) { ?> 
    <label for="name">Name:</label> 
    <input type="text" name="name" /><br />
    <label for="remember_me">Remember Me?</label> 
    <input type="checkbox" name="remember_me" value="remember"/>
    <br/><input type="submit" name="submit" value="Submit"/>
  <?php } ?> 
</form> 