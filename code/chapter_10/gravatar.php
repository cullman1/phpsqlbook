<?php include '../includes/header-register.php'; 
$def = "http://test1.phpandmysqlbook.com/uploads/blank.png";
$size = 100;
if (isset($_POST["email"])) {
  $url = get_gravatar($_POST["email"], $size, $def, 'g', 'false');
}
function get_gravatar($email, $size, $def, $rating, $alt) {
  $url = 'http://www.gravatar.com/avatar/';
  $url .= md5( strtolower( trim( $email ) ) );
  $url .= "?s=$size&d=$def&r=$rating&alt=$alt";
  return $url;
} ?>
<form name="input_form" method="post" action="gravatar.php">
  <div class="col-md-4"><h1>Search For a Gravatar</h1>
    <label for="email">Email: 
    <input type="text" name="email" placeholder="<?php if (isset($_POST["email"])) { echo $_POST["email"]; } ?>" /></label><br/><br/>
    <input type="submit" name="submit" value="Submit" />
    <?php if (isset($_POST["email"])) {  ?>
      <img src="<?php echo $url ?>" style="padding-left:10px;" />
    <?php } ?>
  </div>
</form>
<?php include '../includes/footer-site.php' ?>





