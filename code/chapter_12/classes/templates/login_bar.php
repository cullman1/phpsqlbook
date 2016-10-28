
  <?php if (isset($_SESSION["user2"])) {       
    $so = $_SESSION["user2"];
    $user = unserialize(base64_decode($so));  ?>
   Hello <?php echo $user->getFullName();?>  
     <a href="/cmsfull/profile/set/<?php echo $user->getAuthenticated(); ?>">   Profile</a>&nbsp;   
    <a href="/cmsfull/login/logout/1">Logout</a>
   <?php } else {    ?>             
   <a style="float:right;" href="/cmsfull/login">Login</a>&nbsp;
   <a style="float:right;" href="/cmsfull/register">Register</a>
    <?php } ?> 
  
 