<?php
function checkZipCode($value) {
  try  {
  if(!is_numeric($value) || (empty($value))) {
    throw new InvalidArgumentException('This 
    function only accepts numbers');
  } else if(strlen($value)>10) {
    throw new LengthException('Zipcodes cannot be longer 
    than 10 numbers');
  }
}
  catch (InvalidArgumentException $e) {
    header('Location:../error/Numbers.htm');
  }
  catch (LengthException $e) {
    header('Location:../error/Length.htm');
  }
  return "Valid entry"; 
}
if (($_SERVER['REQUEST_METHOD']) == 'POST') { 
  echo checkZipCode($_POST["zipcode"]);
}
?>
<form action="exception_subtype.php" method="post">
 <label for="zipcode">Enter Zip code: 
 <input type="text" name="zipcode" /></label>
 <input type="submit" value="submit" />
</form>