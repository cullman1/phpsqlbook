<?php
  require_once 'config.php';                                 // Include classes     
  $count = 0;        
  $term = ( isset($_GET['term']) ? trim($_GET['term']) : ''); // Get search term
$errors = array('valid'=>'');
if (!empty($term)) {                                        // If search sent
  $errors['valid'] = Validate::isSearchTerm($term);
  if (strlen(implode($errors)) == 0) {                                            // If data not valid
    $count = $cms->articleManager->getSearchCount($term);          // Get count of matches
    if ($count > 0) {                                         // If matches are found
      $article_list = $cms->articleManager->searchArticles($term); // Get the results
    }
    $display_term = CMS::cleanLink(trim($term));
  }
}
include 'includes/header.php';
?>
    <section class="jumbotron text-center">
        <div class="container">
            <h1 class="jumbotron-heading">Search</h1>
          <?php
          if (!empty($term) && (strlen(implode($errors)) == 0)) {                                         // If search term sent
            echo "You searched for <strong>$display_term</strong>";
            if ($count > 0) {
              echo "<br/>We found $count article(s) containing your term."; //Number of hits
            } else {
              echo "<br/>No articles containing <strong>$display_term</strong> were found";
            }
          } else if (empty($term)) {
            echo 'No search term was supplied';
          } else {
            echo $errors['valid'];
          } ?>
        </div>
    </section>
<div class="container">
  <div class="row">
  <?php
  if ($count > 0) { 
    foreach ($article_list as $article) { ?>
      <div class="card article-summary">
        <a href="<?= ROOT ?>view-article.php?article_id=<?= $article->article_id ?>">
          <img class="card-img-top" src="<?= ROOT ?>uploads/<?= $article->image_file ?>"
           alt="<?= CMS::clean($article->image_alt ) ?>"></a>
        <div class="card-body text-center">
          <a href="<?= ROOT ?>view-article.php?article_id=<?= $article->article_id ?>">
            <h5 class="card-title" ><?= $article->title ?></h5>
          </a>
          <p><?= $article->summary ?></p>
          <p>Posted in 
            <a href="<?= ROOT ?>view-category.php?category_id=
              <?= $article->category_id ?>">
              <?= CMS::clean($article->category) ?>
            </a> 
            by <a href="<?= ROOT ?>view-user.php?user_id=<?= $article->user_id ?>">
            <?= CMS::clean($article->author) ?></a>
          </p>
        </div>
      </div>       
    <?php
    }
  } 
  ?>
  </div>
</div>
<?php include 'includes/footer.php'; ?>