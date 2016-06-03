
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


            </script>
        <?php
       // set default timezone
//date_default_timezone_set('America/Chicago'); // CDT

$current_date = date('d/m/Y == H:i:s');
            echo $current_date."<br/>";
       

         if (isset($_COOKIE["Cookie1"]))
        {
            echo "Cookie1<br/>";
        }

        if (isset($_COOKIE["Cookie2"]))
        {
           echo "Cookie2<br/>";
        }

           if (isset($_COOKIE["Cookie3"]))
        {
            echo "Cookie3<br/>";
        }

        if (isset($_COOKIE["Cookie4"]))
        {
           echo "Cookie4<br/>";
        }

          if (isset($_COOKIE["SameName"]))
        {
           echo "SameName" .  $_COOKIE["SameName"]."<br/>";
        }

         if (isset($_COOKIE["JavascriptTomorrowExpire"]))
        {
            echo "JavascriptTomorrowExpire<br/>";
        }
       
        ?>
    </div>
</div>
</form>

