
<form name="input_form" method="post" action="cookie-experiments.php">
      <div class="wholeform">
      <div class="col-md-4"><h1>One Page Form Submit</h1>
<label for="full_name">Full Name:</label> 
<input type="text" id="full_name" name="full_name" /><br />
<input type="checkbox" id="remember_me" name="remember_me" value="remember" /><br />
<input type="submit" name="submit_button" value="Submit" />
       </div>
            <div>
            <script type="text/javascript">
            function createCookie(name,value,days) {
    if (days) {
        var date = new Date();
        date.setTime(date.getTime()+(days*24*60*60*1000));
        var expires = "; expires="+date.toGMTString();
    } else {
        var expires = "";
    }
    document.cookie = name+"="+value+expires+"";
}

createCookie("thereYouGo","1234", 24);
            </script>
        <?php

        $page=new stdClass();
$page->name='Home';
$page->status=1;
        setcookie("objec",$page,time()+604800);   

         if (isset($_COOKIE["hereNow"]))
        {
            setcookie("hereNow","9000");
        }

        if (isset($_COOKIE["thereYouGo"]))
        {
           echo "Hello".$_COOKIE["thereYouGo"];
        }
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
            if (isset($_POST["remember_me"]))
            {
                setcookie("UserName",$_REQUEST["full_name"],time()+604800);   
            }
        }
        ?>
    </div>
</div>
</form>
