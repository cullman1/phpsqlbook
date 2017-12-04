<?php
  require_once('config.php');                                 // Include classes
                                  
  $term = ( isset($_GET['term']) ? trim($_GET['term']) : ''); // Get search term 
  if (!empty($term)) {                                        // If search sent
    $errors['title'] = (Validate::isText($term, 1, 64) ? '' : 'Not a valid search');
    $count = $articleManager->getSearchCount($term);          // Get count of matches
    if ($count > 0) {                                         // If matches are found
      $article_list = $articleManager->searchArticles($term); // Get the results
    } 
        $display_term = htmlspecialchars(trim($term), ENT_QUOTES, 'UTF-8', TRUE);
  } 
  include 'includes/header.php'; 
?>
<section class="jumbotron text-center">
  <div class="container">
    <h1 class="jumbotron-heading">Search</h1>
   <?php 
     if (!empty($term)) {                                    // If search term sent
       echo "You searched for <strong>$display_term</strong>";
       if ($count > 0) { 
         echo "<br/>We found $count article(s) containing your term."; //Number of hits          
       } else {
         echo "<br/>No articles containing <strong>$display_term</strong> were found";
       }   
    } 
  ?>
  </div>
</section>
<div class="container">
  <div class="row">
    <?php
    if ($count > 0) { 
        foreach ($article_list as $article) {
            include 'includes/article-summary.php';
        }
    }
    ?>
  </div>
</div>
<?php include 'includes/footer.php'; ?>