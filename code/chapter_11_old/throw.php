<?php
function check_value_over_ten($value) {
  try {
    if ($value>10) { 
     throw new Exception("Value too large");
    }
    return "That value is correct";
  }
  catch (Exception $e) {
     echo 'Sorry, the follow error occurred: '; 
    echo $e->getMessage()."<br><br/>";
  
  }
}

if (isset($_POST["check_val"])) {
  echo(check_value_over_ten($_POST["check_val"]));
}
?>
<form action="throw.php" method="post">
 <label for="check_val">Enter value:</label>
 <input type="text" name="check_val" />
 <input type="submit" value="submit" />
</form>