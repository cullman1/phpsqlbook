<?php
include_once '../classes/user.php';
 ?>
 <div style="z-index: 100;">
     <ul class="nav navbar-nav navbar-right floatright">
      <?php if (isset($_SESSION["user2"])) {       
                $so = $_SESSION["user2"];
                $user_object = unserialize($so);  ?>
            <li>Hello <?php echo $user_object->getFullName(); ?>&nbsp;<a href="../code/login/profile.php?userid=<?php echo $user_object->getAuthenticated(); ?>">Profile</a>&nbsp;<a href="../code/login/logout.php">Logout</a></li>
 <?php } else {
                 ?>             
    <li><a href="../code/login/login-user.php">Login</a><a href="../code/login/register4.php">Register</a></li>
    <?php } ?> 
    </ul>
 </div>
