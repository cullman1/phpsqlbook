<!-- this example needs the HTML-ing up when the example code has been written --> 
<style>img {display:none;}</style>
<div>
  <ul class="nav navbar-nav navbar-right floatright">   
    <li><a href="../login/logon.php">Login</a> <a href="../login/register.php">Register</a></li>
    <li>
      <form class="navbar-form navbar-left" role="search" method="get" action="pagination.php">
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
  $trimmed_search = trim($_GET["search"]);              // Trimmed search term
  $count = 2;                                           // Items per page could be in query string
  $page = 0;                                            // Current page (default to 0)
  if (isset($_GET["page"])) { $page = $_GET["page"]; }  // Current page if in query string
  $searchterm =  "AND ((title like '%" . $trimmed_search . "%') "; // What searching for
  $searchterm .= "OR (content like '%" . $trimmed_search . "%'))"; // What searching for

  $total_results =  $dbHost->prepare("select COUNT(*) FROM article  where date_published <= now() " . $searchterm);
  $total_results->execute();
  $total = $total_results->fetchColumn(); 
  $total_pages = ceil($total / $count);                 // Total pages of results

  $search_sql =  "select article_id, title, content, date_posted FROM article ";
  $search_sql .= "where date_published <= now() " . $searchterm;
  $search_sql .= " order by article_id DESC";
  $search_sql .= " limit " . $count . " offset " . ($page * $count);
  $select_articles_result = $dbHost->prepare($search_sql);
  $select_articles_result->execute();
  $select_articles_result->setFetchMode(PDO::FETCH_BOTH);   

  while($get_article = $select_articles_result ->fetch()) { ?>
  <div id="comments_on_article">
    <h3><?php echo $get_article['title']; ?></h3>
    <p><i><?php echo date("F j, Y, g:i a", strtotime($get_article['date_posted'])); ?></i></p>
    <p><?php echo substr($get_article['content'], 0, 100); ?>...</p>
  </div>
  <?php }
}
if ($total > $count) {
  echo '<div class="pagination">';
  for( $i = 0; $i < $total_pages; $i++ ) { // Pagination links
    if ( $page == $i ) {
      echo $i+1 . ' ';
    } else {
      ?><a href="pagination.php?search=<?php echo $trimmed_search; ?>&page=
        <?php echo $i; ?>"><?php echo $i+1; ?></a> <?php 
    }
  }
  echo '</div>';
}
?>