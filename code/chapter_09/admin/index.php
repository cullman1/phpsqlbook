<?php
require_once('../includes/db_config.php');
require_once('../authenticate.php');

function get_articles($connection) {
  $results = new stdClass();   
  $results->connection = $connection;                                // $results is object
  $results->query = "select article_id, title, content, full_name, user.user_id, date_posted, date_published, role_id FROM article left outer JOIN user ON article.user_id = user.user_id   ";
  $statement = $connection->prepare($results->query);                   // Prepare  
  $statement->execute();
  $results->count = $statement->rowCount(); 
  return $results;
 }

 function get_pages($results, $query, $paramslist, $show, $from) {
  $query .= "LIMIT :show ";
  $query .= "OFFSET :from ";
  $statement = $results->connection->prepare($query);
  if (!empty($paramslist)) {
    foreach ($paramslist as $key=>$value) {
        $statement->bindParam(':'.$key, $value);    
    }
  } 
  $statement->bindParam(':show', $show, PDO::PARAM_INT);       // Bind items per page
  $statement->bindParam(':from', $from, PDO::PARAM_INT); 
  $statement->execute();
  $statement->setFetchMode(PDO::FETCH_OBJ);
  $results->matches = $statement->fetchAll();  
  return $results;
}

function get_records($connection, $query, $paramslist='') {
  $results = new stdClass();   
  $results->connection = $connection;                                // $results is object
  $statement = $connection->prepare($query);                   // Prepare  
  if (!empty($paramslist)) {
    foreach ($paramslist as $key=>$value) {
        $statement->bindParam(':'.$key, $value);    
    }
  }
  $statement->execute();
  $results->count = $statement->rowCount(); 
  $statement->setFetchMode(PDO::FETCH_OBJ);
  $results->matches = $statement->fetchAll(); 
  return $results;
 }

function create_pagination($matches, $show, $from) {
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
} 
include '../../includes/header.php'?>
<?php  $show  = (int)( filter_input(INPUT_GET, 'show', FILTER_VALIDATE_INT) ? $_GET['show'] : 10 );
                $from = (int)( filter_input(INPUT_GET, 'from', FILTER_VALIDATE_INT)  ? $_GET['from'] : 0 );
               // $show  = (int) $show;  // In superglobal as string - cast to integer
               // $from = (int) $from;   // In superglobal as string - cast to integer
                $query = "select article_id, title, content, full_name, user.user_id, date_posted, date_published, role_id FROM article left outer JOIN user ON article.user_id = user.user_id ";
                $paramslist = array();

                $results = get_pages(get_records($dbHost, $query, $paramslist), $query, $paramslist, $show,$from); 
            
 // $results = get_records($dbHost, $query, $paramslist); 
                $pagination = create_pagination($results->count,$show,$from);
   ?>
<button onclick="window.location.href='add-article.php';">Add article</button>
<table class="table table-hover">
 <thead>
  <tr><th>Title</th><th>Author</th><th>Date Posted</th>
  <th>Publish Date</th><th>Publish</th> <?php if ($_SESSION["role"]=="9") { ?><th>Delete</th><?php } ?></tr>
 </thead>
 <tbody>
 <?php echo "<tr><td>".$pagination ."</td><tr>";
  foreach ($results->matches as $result) { ?>
  <tr><td><a href="edit.php?id=<?= $result->article_id; ?>">
  <?= $result->title ?></a></td>

  <td>
    <?php if ($_SESSION["role"]=="9") { ?>
      <a href="view-user.php?id=<?= $result->user_id; ?>">
    <?php } ?>
    <?= $result->full_name;?><?php if ($_SESSION["role"]=="9") { ?></a> <?php } ?>
  </td>

  <td><?= $result->date_posted; ?></td>
  
  <?php if ($result->date_published !=null) { ?>
    <td><?= $result->date_published; ?></td>
     <?php } else { ?>
    <td>Not Published</td>
    <?php } ?>
 
  <td><a href="publish.php?id=<?= $result->article_id;  if ($result->date_published!=null) { echo "&publish=delete";} ?>">    
  <?php if ($result->date_published==null) { ?>
  <span class="glyphicon glyphicon-plus"></span>
  <?php } else { ?>
  <span class="glyphicon glyphicon-remove red"></span>
  <?php } ?></a></td>  



   <?php if ($_SESSION["role"]=="9") { ?>
  <td><a onclick="javascript:return confirm(&#39;Do you  really want to delete item <?= $result->article_id;?> ? &#39;);" href="delete.php?id=<?= $result->article_id;?>">
  <span class="glyphicon glyphicon-remove red"></span></a>
  </td>
<?php } ?>

</tr>
    <?php }
     echo "<tr><td>".$pagination ."</td><tr>"; ?>
 </tbody>
 </table>
      <?php include '../../includes/footer.php' ?>
