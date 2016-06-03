<?php echo "Interrupting text"; 
setcookie("Cookie1","111", time() + (60* 1),'code/','test1.phpandmysqlbook.com');
                setcookie("Cookie2","222",time() + (60* 1),'test1.phpandmysqlbook.com');
                   setcookie("Cookie3","333",time() + (60* 1));
                     setcookie("Cookie4","444",time() + (60* 1),'/','test1.phpandmysqlbook.com');

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

//createCookie("JavascriptTomorrowExpire","1234", 0.5);
            </script>
</form>

