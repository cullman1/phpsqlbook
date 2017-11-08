<?php
session_start();
session_set_cookie_params(30*60, '/', '',false, true);

  $color = filter_input(INPUT_POST, 'color', 
                          FILTER_SANITIZE_STRING);  
$name  = filter_input(INPUT_POST, 'name', 
                          FILTER_SANITIZE_STRING);
  if((trim($name) != "") && (trim($color) != "")) {
   $_SESSION["color"] = $color;    
   $_SESSION["name"] = $name;
    header('Location:session-viewer.php');
  } else {
  echo "Please enter your name";
  }
  

?>

<div>
    <a href="home.php">Home</a> | 
    <a href="about.php">About</a> | 
    <a href="services.php">Services</a>
</div>
<form method="post" action="session-set.php"> 
  Choose color:
  <select name="color">
    <option value="#ccede9">green</option>
    <option value="#cceefb">blue</option>
    <option value="#fcdfdb">orange</option>
  </select>
  Name: <input type="text" name="name"  />
  <input type="submit" value="Save" />
</form>
