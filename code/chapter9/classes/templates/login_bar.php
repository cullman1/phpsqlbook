     
<?php include '../classes/user.php' ?>
 <div style="z-index: 100;">
          <ul class="nav navbar-nav navbar-right floatright">
            <?php
  
           if (isset($_SESSION["user2"]))
            {       
           
                $so = $_SESSION["user2"];
                $user_object = unserialize($so); 
           ?>
            <li>Hello <?php echo $user_object->getFullName(); ?>&nbsp;<a href="../login/profile.php">Profile</a>&nbsp;<a href="../login/logout.php">Logout</a></li>
 <?php } else {
                 ?>
             
    <li><a href="../login/login-user.php">Login</a><a href="../login/register4.php">Register</a></li>

  
    <?php } ?> 
      <li><form class="navbar-form navbar-left" role="search" method="post" action="../home">
    <div class="form-group">
        <input id="search" name="search" type="text" class="form-control" placeholder="Search">
    </div>
    <button type="submit" class="btn btn-default">Submit</button>
</form></li>
          </ul>
      </div>
