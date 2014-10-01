<?php
require_once('../includes/db_config.php');
$id = 1;
/* Query SQL Server for selecting data. */
$select_articles_sql = "select article_id, title, content, category_name, category_template, full_name, date_posted, role_id, parent_name, article.parent_id, template FROM article where date_published <= now() order by article_id DESC";

if (isset($_REQUEST["search"]))
{
    $trimmed_search = trim($_REQUEST["search"]);
    $searchterm = "AND ((content like '%". $trimmed_search."' OR content like '". $trimmed_search."%' OR content like '%". $trimmed_search. "%' OR content like '". $trimmed_search."')";
    $searchterm .= " OR (title like '%". $trimmed_search. "' OR title like '". $trimmed_search."%' OR title like '%". $trimmed_search. "%'  OR title like '". $trimmed_search. "'))";
    $select_articles_sql = "select article_id, title, content, date_posted FROM article where date_published <= now() ". $searchterm." order by article_id DESC";

    $select_articles_result = $dbHost->prepare($select_articles_sql);
    $select_articles_result->execute();
    $select_articles_result->setFetchMode(PDO::FETCH_BOTH);   
    while($select_articles_row = $select_articles_result ->fetch())
    { ?>
        <div id="comments_on_article">
            <h3><?php echo $select_articles_row['title']; ?></h3>
            <h5><?php echo date("F j, Y, g:i a", strtotime($select_articles_row['date_posted'])); ?></h5>
            <div class="box2"><?php echo $select_articles_row['content']; ?><br/><br/></div>
        </div>
<?php }
} ?>
<style>    img {
        width: 200px;
    }
</style>
<div style="z-index: 100;">
          <ul class="nav navbar-nav navbar-right floatright">   
    <li><a href="../login/logon.php">Login</a> <a href="../login/register.php">Register</a></li>
  
      <li>
          <form class="navbar-form navbar-left" role="search" method="get" action="search.php">
    <div class="form-group">
        <input id="search" name="search" type="text" class="form-control" placeholder="Search">
    </div>
    <button type="submit" class="btn btn-default">Submit</button>
</form></li>
          </ul>
      </div>
