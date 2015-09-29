 <div class="overlay">
  <ul class="nav navbar-nav navbar-right floatright">
  <?php if (isset($_SESSION["user2"])) {       
    $so = $_SESSION["user2"];
    $user = unserialize(base64_decode($so));  ?>
   <li>Hello <?php echo $user->getFullName();?>  
     <a href="<?php echo "http://".$_SERVER['HTTP_HOST']; ?>/cmsfull/profile/set/<?php echo $user->getAuthenticated(); ?>">   Profile</a>&nbsp;   
    <a href="<?php echo "http://".$_SERVER['HTTP_HOST']; ?>/cmsfull/login/logout/1">Logout</a></li>
   <?php } else {    ?>             
   <li><a href="<?php echo "http://".$_SERVER['HTTP_HOST']; ?>/cmsfull/login">Login</a>&nbsp;
   <a href="<?php echo "http://".$_SERVER['HTTP_HOST']; ?>/cmsfull/register">Register</a></li>
    <?php } ?> 
    </ul>
 </div>