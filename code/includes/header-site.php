<?php 
session_start();
 
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
          <ul class="nav navbar-nav navbar-right floatright">
            <?php
   
           if (isset($_SESSION["user"])) 
            { 
                $so = $_SESSION["user"];
                $user_object = unserialize($so); 
           }?>
            <li>Hello <?php echo $user_object->getFullName(); ?>&nbsp;<a href="../chapter6/logout.php">Logout</a></li>
 <?php } else { ?>
    <li><a href="../chapter6/login-user.php">Login</a><a href="../chapter6/register4.php">Register</a></li>
  
    <?php } ?> 
      <li><form class="navbar-form navbar-left" role="search" method="post" action="../home">
    <div class="form-group">
        <input id="search" name="search" type="text" class="form-control" placeholder="Search">
    </div>
    <button type="submit" class="btn btn-default">Submit</button>
</form></li>
          </ul>
      </div>