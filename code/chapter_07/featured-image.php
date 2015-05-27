<?php
error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', TRUE);
/* Db Details */
require_once('/home/sites/bobbrownendurance.com/public_html/classes/registry.php');
require_once('/home/sites/bobbrownendurance.com/public_html/classes/configuration.php');

//Registy create instance of
$registry = Registry::instance();

//Database
$registry->set('configfile', new Configuration());
$db = $registry->get('configfile');
$pdoString="mysql:host=".$db->getServerName().";dbname=".$db->getDatabaseName();
$pdo = new PDO($pdoString, $db->getUserName(), $db->getPassword()); 
$pdo->setAttribute(PDO::ATTR_FETCH_TABLE_NAMES, true);
$registry->set('pdo', $pdo);
$dbHost =  $registry->get('pdo');

/* include '../includes/header.php';
require_once('../includes/db_config.php');*/ ?> 
<?php if(isset($_GET['featured'])) {   ?>
<form method="post" action="add_article_short.php">
    <div style="width:850px; border:1px solid; overflow:hidden">
<?php  $arr_images = scandir("../uploads/");
       foreach ($arr_images as $image_name) {
           if ($image_name!="." && $image_name!="..") {
               echo  '<div style="display:inline-block; width:110px;"><img u="image" style="width:100px; float:left; margin-right:10px;" src="../uploads/'.$image_name. '" /><br/><label style="margin-left:25px;">Select as featured<input type="radio" name="img_choose" style="margin-top: 10px; margin-left:20px; margin-bottom:10px;" value="'.$image_name.'"/></label></div>';
           }
       }?>   
    <input type="submit" value="Submit" />    
    </div>
    </form>  
 <?php  } ?> 
<?php  include '../includes/footer-site.php'; ?>
