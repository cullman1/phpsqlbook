<?php include '../includes/header-site.php' ?>
   <div class="small_box_top">
        CMS Articles
    </div> 
<div class="small_box">
 
    <div class="pad">
        <?php include 'cms-viewer.php' ?>
    </div>
    <div class="side">
        <?php

include_once '../Facebook/facebook.php';
$config = array('appId' => '464651713667817', 'secret' => 'a8f67bca9e608806baf6a2fae8b53d5b', 'cookie' => true);
$facebook = new Facebook($config);

//Get User ID
include '../Facebook/FacebookSidebar.php';

 ?>

    </div>


 </div>
<?php include('../includes/pagination.php'); ?>
<?php include '../includes/footer-site.php' ?>