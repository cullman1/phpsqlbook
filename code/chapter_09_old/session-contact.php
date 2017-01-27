<?php 
  include 'session-include.php'; 
  $name = isset($_SESSION['name']) 
                ? $_SESSION["name"] : '';
?>
<div>
  <a href='session-home.php'>Home</a> | 
  <a href='session-about.php'>About</a> | 
  <a href='session-services.php'>Services</a>
    <a href='session-contact.php'>Contact Us</a>
</div>
<div>
  <?php if ($name==null) { ?>
    <a href="session-set.php">Preferences</a> 
  <?php } else { ?>
    <a href="session-set.php"><?php echo $name; ?></a> 
  <?php }  ?>
</div>
<div>Welcome to the about page</div>
<?php include 'recently-viewed.php' ?>