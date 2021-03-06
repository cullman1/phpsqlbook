<?php 
//require_once('../classes/FileSessionHandler.php') ;
require_once('../classes/user.php');

function createTree(&$list, $parent){
    $tree = array();
    foreach ((array)$parent as $k=>$l){
        if(isset($list[$l['comments_id']]))
        {
            $l['children'] = createTree($list, $list[$l['comments_id']]);
        }
        $tree[] = $l;
    } 
    return $tree;
}
$new = array();
  
/* Db Details */
require_once('../includes/db_config.php');

/* Query SQL Server for selecting data. */
$select_singlearticle_sql = "select article_id, title, content, category_name, category_template, full_name, date_posted, parent_id, role_id FROM article JOIN user ON article.user_id = user.user_id JOIN category ON article.category_id = category.category_id where article_id=".$_REQUEST["articleid"];
$select_singlearticle_result = $dbHost->prepare($select_singlearticle_sql);
$select_singlearticle_result->execute();
$select_singlearticle_result->setFetchMode(PDO::FETCH_ASSOC);

$select_singlearticleduplicate_result = $dbHost->prepare($select_singlearticle_sql);
$select_singlearticleduplicate_result->execute();
$select_singlearticleduplicate_result->setFetchMode(PDO::FETCH_ASSOC);

$select_singlearticlefull_result = $dbHost->prepare($select_singlearticle_sql);
$select_singlearticlefull_result->execute();
$select_singlearticlefull_result->setFetchMode(PDO::FETCH_ASSOC);



$row= $select_singlearticle_result->fetch();
$select_template_result = "";
$template="";
$parent_id  = $row["parent_id"];
if (isset($parent_id)) {
    $select_template_sql = "select template from parent where parent_id=".$parent_id;
    $select_template_result = $dbHost->prepare($select_template_sql);
    $select_template_result->execute();
    $select_template_result->setFetchMode(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../../assets/ico/favicon.ico">
    <title>Simple CMS Viewer</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <link href="../css/pagination.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

<?php 
if (isset($parent_id)) {

    $select_template_row = $select_template_result->fetch();
    $template = $select_template_row["template"];
}
?>
  <body class="<?php echo $template; ?>">

    <!-- Fixed navbar -->
   
    <div class="container containerback">
       <div style="z-index: 100;">
          <ul class="nav navbar-nav navbar-right floatright">
            <?php
   
             if (isset($_SESSION["user2"])) { 
                $so = $_SESSION["user2"];
                $user_object = unserialize($so);
                $auth = $user_object->getAuthenticated();
                if(!empty($auth)) {
            ?> 
            <li>Hello <?php echo $_SESSION['username']; ?>&nbsp;<a href="../login/logout.php">Logout</a></li>
 <?php } else { ?>
    <li><a href="../login/logon.php?page=pages">Login</a></li>
    <?php }
            } 
               else { ?>
    <li><a href="../login/logon.php?page=pages">Login</a></li>
    <?php } ?> 
          </ul>
      </div>