<?php

require_once('config.php');                    // Include database connection
function clean($text) {
    $text = trim($text);
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8', TRUE);
}
$term = ( isset($_GET['term']) ? $_GET['term'] : ''); // Get search term or blank string
if (!empty($term)) {                                    // If search sent
    $term  = trim($term);                                 // Trim spaces from search term
    $count = $articleManager->getSearchCount($term);    // Get count of matches
    if ($count > 0) {                                     // If matches are found
        $results = $articleManager->searchArticles($term); // Get the results
    } 
    $display_term = clean($term);                         // Output escape the search term
}

include('includes/header.php'); ?>
  <h1>Search</h1>
  <?php 
  if (!empty($term)) {                                           // If search term sent
      echo 'You searched for ' . $display_term . '. ';             // Show search term
      echo 'We found ' . $count . ' result(s).<br><br>';           // Number of results
  }
  if (!empty($results)) {                                        // If you have results
      foreach ($results as $article) {                             // Loop through them
          echo '<p><a href="article.php?id=' . $article->id . '">';  // Link to article
          echo clean($article->title) . '</a><br>';                  // Show title
          echo clean(substr($article->content, 0, 100)) . '...</p>'; // Show 1st 100 chars
      }
  }
  if (empty($results)) {                            // If no search results show form
  ?>
  <form method="get" action="search.php">
    <input name="term" type="text" placeholder="Search">
    <input type="submit" name="submit" value="search">
  </form>
  <?php } ?>
  <?php include('includes/footer.php'); ?>