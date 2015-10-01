  <ul class="nav navbar-nav navbar-right floatright">
  <?php if (isset($_SESSION["user2"])) {       
    $so = $_SESSION["user2"];
    $user = unserialize(base64_decode($so));  ?>
   <li>Hello <?php echo $user->getFullName();?>  
     <a href="/cmsfull/profile/set/<?php echo $user->getAuthenticated(); ?>">   Profile</a>&nbsp;   
    <a href="/cmsfull/login/logout/1">Logout</a></li>
   <?php } else {    ?>             
   <li><a href="/cmsfull/login">Login</a>&nbsp;
   <a href="/cmsfull/register">Register</a></li>
    <?php } ?> 
    </ul>
 