<?php
if($_SERVER['REQUEST_METHOD'] == 'POST') {
     if (isset($_COOKIE["colorChoice"])) {
       setcookie("colorChoice","",time() - (60* 1),"/");  
     }
     setcookie("colorChoice",$_POST["changer"], time() + (60* 1),"/");    
     include("style1.php");
     echo "<br/>Color scheme changed to " . $_POST["changer"];         
 } else if (isset($_COOKIE["colorChoice"])) {
       include("style.php");
     } 
?>
<form name="input_form" method="post" action="cookie-color-changer.php"> 
    <script type="text/javascript">
        function changeColor() {
            document.body.style.background = document.getElementById("changer").value;
        }
    </script>
    <label for="full_name">Choose color:
        <select id="changer" name="changer" onchange="changeColor()">
         <option value="#000000" selected>Select a color</option>
            <option value="#ccede9" >green</option>
            <option value="#cceefb">blue</option>
            <option value="#fcdfdb">orange</option>
            <option value="#e6e3e1">gray</option>
        </select>
    </label> 
    <br />
    <br />
    <input type="submit" name="submit_button" value="Submit" />
</form>

