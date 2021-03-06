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
$id = 1;
/* Query SQL Server for selecting data. */
$select_articles_sql = "select article_id, title, content, category_name, category_template, full_name, date_posted, role_id, parent_name, article.parent_id, template FROM article JOIN user ON article.user_id = user.user_id  JOIN parent ON article.parent_id = parent.parent_id JOIN category ON article.category_id = category.category_id where date_published <= now() order by article_id DESC";
if (isset($_REQUEST["search"]))
{
    $searchterm = "AND ((content like '%".$_REQUEST["search"]."' OR content like '".$_REQUEST["search"]."%' OR content like '%".$_REQUEST["search"]."%'  OR content like '".$_REQUEST["search"]."')";
    $searchterm .= " OR (title like '%".$_REQUEST["search"]."' OR title like '".$_REQUEST["search"]."%' OR title like '%".$_REQUEST["search"]."%'  OR title like '".$_REQUEST["search"]."'))";
    $select_articles_sql = "select article_id, title, content, category_name, category_template, full_name, date_posted, role_id, parent_name, article.parent_id, template FROM article JOIN user ON article.user_id = user.user_id  JOIN parent ON article.parent_id = parent.parent_id JOIN category ON article.category_id = category.category_id where date_published <= now() ". $searchterm." order by article_id DESC";
}

$select_articles_result = $dbHost->prepare($select_articles_sql);
$select_articles_result->execute();
$select_articles_result->setFetchMode(PDO::FETCH_ASSOC);

/* Query SQL Server for selecting template. */
$select_template_sql = "select template from parent where parent_id=".$id;
$select_template_result = $dbHost->prepare($select_template_sql);
$select_template_result->execute();
$select_template_result->setFetchMode(PDO::FETCH_ASSOC);
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
$select_template_row = $select_template_result->fetch();
$template = $select_template_row["template"];
?>
  <body class="<?php echo $template; ?>">

    <!-- Fixed navbar -->
   
    <div class="container containerback">
       <div style="z-index: 100;">
   
      </div>