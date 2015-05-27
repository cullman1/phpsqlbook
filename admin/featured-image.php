<?php
require_once('../classes/registry.php');
require_once('../classes/configuration.php');
include ('../includes/header.php'); 

//Registy create instance of
$registry = Registry::instance();
$registry->set('configfile', new Configuration());
$db = $registry->get('configfile');
$pdoString="mysql:host=".$db->getServerName().";dbname=".$db->getDatabaseName();
$pdo = new PDO($pdoString, $db->getUserName(), $db->getPassword()); 
$pdo->setAttribute(PDO::ATTR_FETCH_TABLE_NAMES, true);
$registry->set('pdo', $pdo);
$dbHost =  $registry->get('pdo');
if(isset($_GET['featured'])) { ?>
<form method="post" action="<?php echo $_GET['featured'];?>-article.php<?php if ($_GET["featured"]=="edit"){ echo "?article_id=".$_GET['article_id']; } ?>">
    <div style="width:950px; overflow:hidden; background-color:lightgray; padding-left:10px; padding-top: 10px;">
<?php  $arr_images = scandir("../uploads/");
       foreach ($arr_images as $image_name) {
           if (($image_name!=".") && ($image_name!="..") && (strpos($image_name,".jpg",0)>0)) {
               echo  '<div style="display:inline-block; width:110px;"><img u="image" style="width:100px; float:left; margin-right:10px;" src="../uploads/'.$image_name. '" /><br/><label style="font-weight:bold; font-size:12px; background-color:lightgray">Make Featured Image<input type="radio" name="img_choose" style="margin-top: 10px; margin-left:20px; margin-bottom:10px;" value="'.$image_name.'"/></label></div>';
           }
       }?>   
    <br /><br /><br /><input type="submit" value="Submit Choice of Image" />    
    </div>
    </form>  
 <?php  } ?> 
<?php  include '../includes/footer-site.php'; ?>
