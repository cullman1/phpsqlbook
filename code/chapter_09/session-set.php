<?php
session_start();
if($_SERVER['REQUEST_METHOD'] == 'POST') {  
  $name  = filter_input(INPUT_POST, 'name', 
                          FILTER_SANITIZE_STRING);
  $color = filter_input(INPUT_POST, 'color', 
                          FILTER_SANITIZE_STRING);
  if($name != null){
    $_SESSION["name"] = $name;
  }
  if ($color != null) {
    $_SESSION["color"] = $color;
  }
  header('Location:session-viewer.php');
}
?>
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