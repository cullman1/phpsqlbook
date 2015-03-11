<!-- this example needs the HTML-ing up when the example code has been written --> 

<div>
  <ul class="nav navbar-nav navbar-right floatright">   
    <li><a href="../login/logon.php">Login</a> <a href="../login/register.php">Register</a></li>
    <li>
      <form class="navbar-form navbar-left" role="search" method="get" action="search.php">
        <div class="form-group">
          <input id="search" name="search" type="text" placeholder="Search">
        </div>
        <input type="submit" name="submit">
      </form>
    </li>
  </ul>
</div>

<?php
require_once('../includes/db_config.php');
if (isset($_REQUEST["search"])) {
  $trimmed_search = trim($_GET["search"]);
  $searchterm =  "AND ((title like '%" . $trimmed_search . "%') ";
  $searchterm .= "OR (content like '%" . $trimmed_search . "%'))";
  $search_sql =  "select article_id, title, content, date_posted FROM article ";
  $search_sql .= "where date_published <= now() " . $searchterm . " order by article_id DESC";

  $select_articles_result = $dbHost->prepare($search_sql);
  $select_articles_result->execute();
  $select_articles_result->setFetchMode(PDO::FETCH_BOTH);   
  while($get_article = $select_articles_result ->fetch())
  { ?>
  <div id="comments_on_article">
    <h3><?php echo $get_article['title']; ?></h3>
    <p><i><?php echo date("F j, Y, g:i a", strtotime($get_article['date_posted'])); ?></i></p>
    <p><?php echo substr($get_article['content'], 0, 100); ?>...</p>
  </div>
  <?php
  }
}
?>