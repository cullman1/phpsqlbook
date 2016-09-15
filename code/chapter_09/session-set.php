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
Choose color scheme:
  <select name="color">
    <option value="light">light</option>
    <option value="dark">dark</option>
  </select>
  Name: <input type="text" name="name"  />
  <input type="submit" value="Save" />
</form>