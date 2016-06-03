<?php setcookie("SameName","9999", time() + (1800* 1));
             

        echo "Cookies set";
       
        ?>
<form name="input_form" method="post" action="cookie-experiments2.php">
      <div class="wholeform">
      <div class="col-md-4"><h1>One Page Form Submit</h1>
<label for="full_name">Full Name:</label> 
<input type="text" id="full_name" name="full_name" /><br />
<input type="checkbox" id="remember_me" name="remember_me" value="remember" /><br />
<input type="submit" name="submit_button" value="Submit" />
       </div>
            <div>
      
    </div>
</div>
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

createCookie("SameName","1234", 0.5);
            </script>
</form>

