<?php
session_start();
session_set_cookie_params(30*60, '/', '', false, true);
if($_SERVER['REQUEST_METHOD'] == 'POST') {  
  $color = filter_input(INPUT_POST, 'color', 
                          FILTER_SANITIZE_STRING);
  $name  = filter_input(INPUT_POST, 'name', 
                          FILTER_SANITIZE_STRING);
  if((trim($color) != '') && (trim($name) != '')) {
    $_SESSION['color'] = $color;
    $_SESSION['name']  = $name;
    header('Location:session-viewer.php');
  } else {
    echo 'Please enter your name';
  }
}
?>
<form method="post" action="session-set.php"> 
Select color scheme:
  <select name="color">
    <option value="dark">dark</option>
    <option value="light">light</option>
  </select><br/>
  Name: <input type="text" name="name"  /><br/>
  <input type="submit" value="Save" />
</form>