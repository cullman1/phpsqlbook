<?php 
    if (isset($_SESSION["login"])) {     
    $so = $_SESSION["user2"];
    $user = unserialize(base64_decode($so));  ?>
   Hello <?php echo $user->getFullName();?>  
     <a href="/phpsqlbook/profile/update?id=<?php echo $_SESSION["login"]; ?>">   Profile</a>&nbsp;   
    <a href="/phpsqlbook/login/logout/">Logout</a>
   <?php } else {    ?>             
   <a style="float:right;" href="/phpsqlbook/login">Login</a>&nbsp;
   <a style="float:right;" href="/phpsqlbook/register">Register</a>
    <?php } ?> 

 