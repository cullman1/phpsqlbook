<?php 
    if (isset($_SESSION["loggedin"])) {  
        
    $so = $_SESSION["user2"];
    $user = unserialize(base64_decode($so));  ?>
   Hello <?php echo $user->getFullName();?>  
     <a href="/phpsqlbook/profile/view?id=<?php echo $user->getAuthenticated(); ?>">   Profile</a>&nbsp;   
    <a href="/phpsqlbook/login/logout/">Logout</a>
   <?php } else {    ?>             
   <a style="float:right;" href="/phpsqlbook/login">Login</a>&nbsp;
   <a style="float:right;" href="/phpsqlbook/register">Register</a>
    <?php } ?> 
  
 