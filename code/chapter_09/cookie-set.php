<?php
if($_SERVER['REQUEST_METHOD'] == 'POST') {
  $name  = filter_input(INPUT_POST, 'name', 
                          FILTER_SANITIZE_STRING);
  $color = filter_input(INPUT_POST, 'color', 
                          FILTER_SANITIZE_STRING);
  if($name != null){
    setcookie('name', $name, time() + (60 * 1), '/');
  }
  if ($color != null) {
    setcookie('color', $color, time() + (60 * 1), '/');
  }
  header('Location:cookie-viewer.php');
}
?>
<form method="post" action="cookie-set.php"> 
  Select color scheme:
  <select name="color">
    <option value="dark">dark</option>
    <option value="light">light</option>
  </select><br/>
  Name: <input type="text" name="name"  /><br/>
  <input type="submit" value="Save" />
</form>