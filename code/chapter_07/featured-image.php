<?php
error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', TRUE);
include ('../includes/header.php'); 
require_once('../includes/db_config.php');
$sel_media_set = $dbHost->prepare("select * FROM 387732_phpbook1.media");
$sel_media_set->execute();
$sel_media_set->setFetchMode(PDO::FETCH_ASSOC);
if(isset($_GET['featured'])) { ?>
  <form method="post" action="<?php echo $_GET['featured'];?>_article_amended.php<?php if ($_GET["featured"]=="edit"){ echo "?article_id=".$_GET['article_id']; } ?>">
    <div class="image_wall">
      <?php  while ($sel_media_row = $sel_media_set->fetch()) { 
                 echo  '<div class="div_pos"><img class="img_pos" src="../uploads/'.$sel_media_row["file_name"]. '" /><br/><label class="label_pos">Make Featured Image<input type="radio" name="img_name" class="radio_pos" value="'.$sel_media_row["file_name"].'"/><input type="hidden" name="img_id" value="'.$sel_media_row["media_id"].'" /></label></div>';
      } ?>   
  
    </div>
        <input type="submit" value="Submit Choice of Image" />    
  </form>  
<?php  } ?> 
<?php  include '../includes/footer-site.php'; ?>
