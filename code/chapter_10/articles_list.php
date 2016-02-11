<?php 
include ('header-content.php');
require_once ('../includes/db_config.php');

function get_articles($dbHost, $show, $from) {
 $sql = "select * FROM article JOIN user ON article.user_id = user.user_id JOIN category ON article.category_id = category.category_id order by article_id LIMIT :show OFFSET :from ";  
 $statement = $dbHost->prepare($sql);
 $statement->bindParam(':show', $show, PDO::PARAM_INT);      
 $statement->bindParam(':from', $from, PDO::PARAM_INT); 
 $statement->execute();
 return $statement;
}

function count_articles($dbHost) {
 $date = date('Y-m-d H:i:s', strtotime(str_replace('-', '/', date("Y-m-d H:i:s"))));
 $sql = "select Count(*) As TotalRecords FROM article where date_published <= :date" ;
 $statement = $dbHost->prepare($sql);
 $statement->bindParam(":date",$date);
 $statement->execute();
 $statement->setFetchMode(PDO::FETCH_ASSOC);
 $select_totalrecords_row = $statement->fetch();
 $totalRecords = $select_totalrecords_row["TotalRecords"];
 return $totalRecords;
}

function create_pagination($total, $show, $from) {
  $pages   = ceil($total / $show);     // Total pages
  $current = ceil($from / $show);        // Current page
  $result  = NULL;
  if ($pages > 1) {
    for ($i = 0; $i < $pages; $i++) {
      if ($i == ($current)) {
        $result .= ($i + 1) . '&nbsp;';
      } else {
        $result .= '<a href="articles_list.php?show=' . $show;
        $result .= '&from=' . ($i * $show) . '">' . ($i + 1) . '</a>&nbsp;';
      }
    }
  }
  return $result;
}

$show = (int)(filter_input(INPUT_GET, 'show', FILTER_VALIDATE_INT) ? $_GET['show'] : 10);
$from = (int)(filter_input(INPUT_GET, 'from', FILTER_VALIDATE_INT) ? $_GET['from'] : 1);
$num_rows = count_articles($dbHost);
if($num_rows==0){
    echo "<div class='box2'>No articles have been published.</div>";
} else {
  $statement = get_articles($dbHost,$show, $from);
  $pagination = create_pagination($num_rows, $show, $from);
  echo $pagination; 
} ?>

<div style="margin-top:150px;"></div>

<?php while($row =$statement->fetch()) {   ?>

<div id="category_container" style="width:500px; margin-left:20px;" class="<?= $row['category_template']; ?>">
      <h3><a href="single_article.php?article_id=<?= $row['article_id']; ?>"><?= $row['title']; ?></a></h3>
      <h5><?= date("F j, Y, g:i a", strtotime($row['date_posted'])); ?></h5>
      <div class="box"><?= $row['content']; ?><br/>      </div>
</div>
  <?php  }
include 'footer.php' ?>

