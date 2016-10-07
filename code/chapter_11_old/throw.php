<?php

function check_input($value) {
  try {
    if ($value>10) { 
      throw new Exception("Value too large");
    }
    return "That value is correct";
  }
  catch (Exception $e) {
    return $e->getMessage();
  }
}
if (isset($_POST["check_val"])) {
echo(check_input($_POST["check_val"]));
}
?>
<form action="throw.php" method="post">
<label for="check_val">Enter value:</label>
<input type="text" name="check_val" />
<input type="submit" value="submit"/>
</form>