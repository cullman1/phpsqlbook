<?php include_once '../classes/user.php'; ?>
 <div class="overlay">
  <ul class="nav navbar-nav navbar-right floatright">
  <?php if (isset($_SESSION["user2"])) {       
    $so = $_SESSION["user2"];
    $user = unserialize($so);  ?>
   <li>Hello <?php echo $user->getFullName();?>  
   &nbsp;<a href="../pages/login/profile.php? userid=<?php echo $user->getAuthenticated();
 ?>">Profile</a>&nbsp;<a href="../pages/login/logout.php">Logout</a></li>
 <?php } else {    ?>             
    <li><a href="../pages/login/login-user.php">Login</a><a href="../pages/login/register4.php">Register</a></li>
    <?php } ?> 
    </ul>
 </div>