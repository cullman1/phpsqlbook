<?php
require_once('../includes/db_config.php');

function get_articles($connection) {
  $query = "select article_id, title, content, full_name, user.user_id, date_posted, date_published, role_id FROM article left outer JOIN user ON article.user_id = user.user_id  order by article_id";
  $statement = $connection->prepare($query);
  $statement->execute();
    $results = new stdClass();                                   // $results is object
  $results->count = $statement->rowCount(); 
  $statement->setFetchMode(PDO::FETCH_OBJ);

  $results->matches = $statement->fetchAll();  
  return $results;
}

function create_pagination($matches, $show = 2, $from = 0) {
  $pages = ceil($matches / $show);     // Total matches
  $current = ceil($from / $show);      // Current page
  $result = NULL;
  if ($pages > 1) {
    for ($i = 0; $i < $pages; $i++) {
      if ($i == ($current)) {
        $result .= ($i + 1) . '&nbsp;';
      } else {
        $result .= '<a href="index.php?show=' . $show;
        $result .= '&from=' . ($i * $show) . '">' . ($i + 1) . '</a>&nbsp;';
      }
    }
  }
  return $result;
} ?>
      <button type="button" class="btn btn-default" onclick="window.location.href='add-article.php';">Add article</button>
      <table class="table table-hover">
        <thead>
          <tr>
            <th>Title</th>
            <th>Author</th>
            <th>Date Posted</th>
            <th>Date to Publish</th>
            <th>Publish</th>
            <th>Delete</th>
          </tr>
        </thead>
        <tbody>
         <?php $results = get_articles($dbHost); 
               $pagination = create_pagination($results->count);
               echo $pagination;
               $count=0;
               foreach ($results->matches as $result) {               
          $count++; // For each result?>
          <tr>
            <td><a href="edit-article.php?article_id=<?= $result->article_id; ?>"><?= $result->title ?></a></td>
            <td><a href="author-view.php?userid=<?= $result->user_id; ?>"><?= $result->full_name; ?></a></td>
            <td><?= $result->date_posted; ?></td>
            <?php if ($result->date_published !=null) { ?>
              <td><?= $result->date_published; ?></td>
            <?php } else { ?>
              <td>Not Published</td>
         <?php } ?>
            <td><a href="publish-data.php?articleid=<?= $result->article_id; if ($result->date_published!=null) { echo "&publish=delete";} ?>">    
            <?php if ($result->date_published==null)            { ?>
               <span class="glyphicon glyphicon-plus"></span> <?php } else { ?><span class="glyphicon glyphicon-remove red"></span><?php } ?></a></td>
      
            <td><a onclick="javascript:return confirm(&#39;Are you sure you want to delete this item<?= $result->article_id;?>&#39;);" id="delete1" href="delete-data.php?article_id=<?= $result->article_id;?>".><span class="glyphicon glyphicon-remove red"></span></a></td>

         </tr>
                <?php }
echo $pagination;
 ?>
        </tbody>
      </table>
