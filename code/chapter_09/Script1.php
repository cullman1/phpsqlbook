<form method="get" action="search-paginated.php">
  <input id="search" name="search" type="text" placeholder="Search">
  <input type="submit" name="submit" value="search"> </form> <?php
require_once('includes/db-connection.php');                    // Connection

function perform_search($connection, $term, $show = 2, $from = 0) {
  $query =  "SELECT article_id, title, publish_date, content FROM article ";
  $query .= "WHERE ((title LIKE :term) OR (content LIKE :term)) ";
  $query .= "ORDER BY article_id DESC ";                 // Query

  $like_term = '%' . $term . '%';

  $statement = $connection->prepare($query);                   // Prepare 
  $statement->bindParam(':term', $like_term, PDO::PARAM_STR);  // Bind search term
  $statement->execute();                                       // Execute

  $results = new stdClass();                                   // $results is object
  $results->count = $statement->rowCount();                    // Number of results

  $query .= "LIMIT :show ";
  $query .= "OFFSET :from ";

  $statement = $connection->prepare($query);                   // Prepare 
  $statement->bindParam(':term', $like_term, PDO::PARAM_STR);  // Bind search term
  $statement->bindParam(':show', $show, PDO::PARAM_INT);       // Bind items per page
  $statement->bindParam(':from', $from, PDO::PARAM_INT);       // Bind offset
  $statement->execute();                                       // Execute
  $statement->setFetchMode(PDO::FETCH_OBJ);                    // Object syntax
  $results->matches = $statement->fetchAll();                  // Matches in database

  return $results;                                             // Return results object
}

function create_pagination($term, $matches, $show = 2, $from = 0) {

  $pages = ceil($matches / $show);     // Total matches
  $current = ceil($from / $show);      // Current page
  $result = NULL;
  if ($pages > 1) {
    for ($i = 0; $i < $pages; $i++) {
      if ($i == ($current)) {
        $result .= ($i + 1) . '&nbsp;';
      } else {
        $result .= '<a href="search-paginated.php?search=' . $term . '&show=' . $show;
        $result .= '&from=' . ($i * $show) . '">' . ($i + 1) . '</a>&nbsp;';
      }
    }
  }

  return $result;
}

if ( (isset($_GET["search"])) && (!empty(trim($_GET["search"]))) ) { // If search sent
  $term   = trim($_GET["search"]);                                   // Get search term
  $show  = ( filter_input(INPUT_GET, 'show', FILTER_VALIDATE_INT) ? $_GET['show'] : 2 );
  $from = ( filter_input(INPUT_GET, 'from', FILTER_VALIDATE_INT)  ? $_GET['from'] : 0 );
  $show  = (int) $show;  // In superglobal as string - cast to integer
  $from = (int) $from;   // In superglobal as string - cast to integer

  $results = perform_search($connection, $term, $show, $from);       // Call function

  if ($results->count == 0) {                                        // If no matches
    echo 'No matches found for ' . $term;                            // Tell user
  } else {                                                           // Otherwise
    echo 'Matches: ' . $results->count . '<br>';               // No of results
  
    // Stores the result in a variable so that it can be shown top and bottom of the page
    $pagination = create_pagination($term, $results->count, $show, $from);
    echo $pagination;

    foreach ($results->matches as $result) {                         // For each result
    ?>
      <h3><a href="article.php?article_id=<?= $result->article_id; ?>">
          <?= $result->title; ?></a></h3>
      <p><i><?= date("F j, Y", strtotime($result->publish_date)); ?></i></p>
      <p><?= substr($result->content, 0, 100); ?></p>
    <?php 
    }                                                          // End loop code block

    echo $pagination;
  }                                                            // End if statement

}                                                              // End if statement
?>
