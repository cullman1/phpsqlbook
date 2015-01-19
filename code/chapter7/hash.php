<?php include '../includes/header-register.php' ?>
<form name="input_form" method="post" action="hash.php">
      <div class="wholeform">
      <div class="col-md-4"><h1>Hash</h1>
<label for="full_name">Enter a Password:</label> 
<input type="text" id="password" name="password" /><br />
<input type="submit" name="submit_button" value="Submit" />
       </div>
            <div>
        <?php
        if (isset($_REQUEST["password"]))
        {
            $sha1Password = sha1($_REQUEST["password"]);
            $md5Password = md5($_REQUEST["password"]);
            $preSalt = "grF!y1";
            $afterSalt = "d!@hb3";
            $saltedPassword = sha1($preSalt . $_REQUEST["password"] .$afterSalt);
            echo "Your password was: ".$_REQUEST["password"]."<br/>";
            echo "The SHA1 encrypted version was: ".$sha1Password."<br/>";
            echo "The MD5 encrypted version was: ".$md5Password."<br/>";
            echo "The salted version was: ".$saltedPassword."<br/>";
        }
        ?>
    </div>
</div>
</form>


<?php include '../includes/footer-register.php' ?>
