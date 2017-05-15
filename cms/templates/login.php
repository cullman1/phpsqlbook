<?php 
    if (isset($_SESSION["user_id"])) {      ?>
   Hello <?php echo $_SESSION["user_id"];?>  
     <a href="/phpsqlbook/profile/update?id=<?php echo $_SESSION["user_id"]; ?>">   Profile</a>&nbsp;   
    <a href="/phpsqlbook/login/logout/">Logout</a>
   <?php } else {    ?>             
   <a style="float:right;" href="/phpsqlbook/login">Login</a>&nbsp;
   <a style="float:right;" href="/phpsqlbook/register">Register</a>
    <?php } ?> 