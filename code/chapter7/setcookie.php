<?php include '../includes/header-register.php' ?>
<form name="input_form" method="post" action="single_form.php">
      <div class="wholeform">
      <div class="col-md-4"><h1>One Page Form Submit</h1>
<label for="full_name">Full Name:</label> 
<input type="text" id="full_name" name="full_name" /><br />
<input type="checkbox" id="remember_me" name="remember_me" value="remember" /><br />
<input type="submit" name="submit_button" value="Submit" />
       </div>
            <div>
        <?php
        if (isset($_COOKIE["full_name"]))
        {
            echo "<br/>Hello ".$_REQUEST["full_name"].", welcome to our site";
        }
        else
        {
            if (!empty($_REQUEST["full_name"]))
            {
	            echo "<br/>Hello ".$_REQUEST["full_name"].", welcome to our site";
            }
            if ($_REQUEST["remember_me"]=="remember")
            {
                setcookie("UserName",$_REQUEST["full_name"],time()+604800);   
            }
        }
        ?>
    </div>
</div>
</form>
<?php include '../includes/footer-register.php' ?>
