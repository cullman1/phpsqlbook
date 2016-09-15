
<?php 
function hash_password($password) {
  $sha1Passwd = sha1($password);
  $md5Passwd = md5($password);
  $preSalt = "3RF!y1";
  $afterSalt = "dd4hb3";
  $saltedPasswd=sha1($preSalt.$password .$afterSalt);    
  $hash = password_hash($password, PASSWORD_DEFAULT);        
  echo "Your password was: ".$password."<br/>";  
  echo "The SHA1 encrypted version was:".$sha1Passwd."<br/>";
  echo "The MD5 encrypted version was: ".$md5Passwd."<br/>";
  echo "The salted version was: ".$saltedPasswd."<br/>";  
  echo "The password hash version was: ".$hash."<br/>";  
} ?>
<form name="input_form" method="post" class="indent"  action="hash.php">
  <h1>Hash</h1>
  <label for="full_name">Enter a Password:</label> 
  <input type="text" id="password" name="password" />
  <div class="clear"></div>
  <input type="submit" value="Submit" />
  <div class="clear"></div>
  <?php if (isset($_POST["password"])) {
    hash_password($_POST["password"]);
    } ?>
</form>

