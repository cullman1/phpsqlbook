
<?php include '../includes/header-register.php'; 

$default = "http://test1.phpandmysqlbook.com/uploads/blank.png";
$size = 100;
$url = "";

if (isset($_REQUEST["email"]))
{
	$url = get_gravatar($_REQUEST["email"], $size, $default, 'g', $false);
}

function get_gravatar( $email, $size, $default, $rating, $img, $atts = array() ) {
    $url = 'http://www.gravatar.com/avatar/';
    $url .= md5( strtolower( trim( $email ) ) );
    $url .= "?s=$size&d=$default&r=$rating";
    if ( $img ) {
        $url = '<img src="' . $url . '"';
        foreach ( $atts as $key => $val )
            $url .= ' ' . $key . '="' . $val . '"';
        $url .= ' />';
    }
    return $url;
}


?>
<form name="input_form" method="post" action="gravatar.php">
      <div class="wholeform">
      <div class="col-md-4"><h1>Search For a Gravatar</h1>
<label for="email">Email:</label> 
<input type="text" id="email" name="email" /><br /><br />
<input type="submit" name="submit_button" value="Submit" /><br /><br />
       </div>
            <div>
 <?php  if (isset($_REQUEST["email"]))
{  ?>
<img src="<?php echo $url ?>" alt="" />
<?php } ?>
    </div>
</div>
</form>
<?php include '../includes/footer-site.php' ?>





