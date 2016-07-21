<?php
if($_SERVER['REQUEST_METHOD'] == 'POST') {
  $name  = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
  $color = filter_input(INPUT_POST, 'color',                           FILTER_SANITIZE_STRING);
  if($name != null){
    setcookie('name', $name, time() + (60 * 1), "/");
  }
  if ($color != null) {
    setcookie('color', $color, time() + (60 * 1), "/");
  }
  header('Location:cookie-viewer.php');
}
?>
<form method="post" action="cookie.php"> 
  Choose color:
  <select name="color">
    <option value="#ccede9">green</option>
    <option value="#cceefb">blue</option>
    <option value="#fcdfdb">orange</option>
  </select>
  Name: <input type="text" name="name"  />
  <input type="submit" value="Save" />
</form>

