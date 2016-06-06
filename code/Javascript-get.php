<?php

              setcookie("tomorrowExpireCodePath","3333", time() + (43200* 1),'code/','test1.phpandmysqlbook.com');
                setcookie("tomorrowExpireNoPath","5555",time() + (43200* 1),'test1.phpandmysqlbook.com');
                      setcookie("tomorrowExpireNoExpiry","5535",time() + (1800* 1));
                     setcookie("tomorrowExpireRootPath","5535",time() + (43200* 1),'/','test1.phpandmysqlbook.com');

         if (isset($_COOKIE["tomorrowExpireCodePath"]))
        {
            echo "tomorrowExpireCodePath";
        }

        if (isset($_COOKIE["tomorrowExpireNoPath"]))
        {
           echo "tomorrowExpireNoPath";
        }

           if (isset($_COOKIE["tomorrowExpireCodePath"]))
        {
            echo "tomorrowExpireNoExpiry";
        }

        if (isset($_COOKIE["tomorrowExpireNoPath"]))
        {
           echo "tomorrowExpireRootPath";
        }
       
        ?>
        <form name="input_form" method="post" action="cookie-experiments.php">
<div class="wholeform">
      <div class="col-md-4"><h1>One Page Form Submit</h1>
<label for="full_name">Full Name:</label> 
<input type="text" id="full_name" name="full_name" /><br />
<input type="checkbox" id="remember_me" name="remember_me" value="remember" /><br />
<input type="submit" name="submit_button" value="Submit" />
       </div>
            <div>
    </div>
     <script type="text/javascript">
          function getCookie(name)
  {
    var re = new RegExp(name + "=([^;]+)");
    var value = re.exec(document.cookie);
    return (value != null) ? unescape(value[1]) : null;
  }

var abc = getCookie("JavascriptTomorrowExpire");
alert("Value:" + abc);
            </script>
</div>
</form>

