<?php 
session_start();

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
$select_singlearticle_sql = "select article_id, title, content, category_name, user_name, date_posted, parent_id, role_id FROM article JOIN user ON article.user_id = user.user_id JOIN category ON article.category_id = category.category_id where article_id=".$_REQUEST["articleid"];
$stmt = mysql_query($select_singlearticle_sql);
$select_singlearticle_result = mysql_query($select_singlearticle_sql);
if(!$stmt)
{  
    die("Query failed: ". mysql_error());
}
$select_singlearticle_row = mysql_fetch_array($select_singlearticle_result);

$parent_id  = $select_singlearticle_row["parent_id"];

$select_template_sql = "select template from parent where parent_id=".$parent_id;
$select_template_result = mysql_query($select_template_sql);
if(!$select_template_result) {      die("Query failed: ". mysql_error()); }
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
    <style>
      body {
        min-height: 2000px;
        padding-top: 70px;
      }
      .red{
        color:red;
      }
    </style>
    <!-- Custom styles for this template -->
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

<?php 
$select_template_row = mysql_fetch_array($select_template_result);
$template = $select_template_row["template"];
?>
  <body class="<?php echo $template; ?>">

    <!-- Fixed navbar -->
   
    <div class="container containerback">
       <div style="z-index: 100;">
          <ul class="nav navbar-nav navbar-right floatright">
            <?php
   
            if (isset($_SESSION['authenticated'])) { ?> 
            <li>Hello <?php echo $_SESSION['username']; ?>&nbsp;<a href="../login/logout.php">Logout</a></li>
 <?php } else { ?>
    <li><a href="../login/logon.php">Login</a><a href="../login/register.php">Register</a></li>

    <?php } ?> 
          </ul>
      </div>