 <div class="overlay">
  <ul class="nav navbar-nav navbar-right floatright">
  <?php if (isset($_SESSION["user2"])) {       
    $so = $_SESSION["user2"];
    $user = unserialize($so);  ?>
   <li>Hello <?php echo $user->getFullName();?>  
    <a href="login/logout.php">Logout</a></li>
   <?php } else {    ?>             
   <li><a href="login/login-user.php">Login</a>&nbsp;
   <a href="login/register.php">Register</a></li>
    <?php } ?> 
    </ul>
 </div>