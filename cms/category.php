<?php 
error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', TRUE);
session_start();
require_once('includes/class-lib.php');
require_once('includes/functions.php');
require_once('includes/database-connection.php');

if (isset($_GET['name'])) {
  $title = ( isset($_GET['name']) ? $_GET['name'] : '' );
  $show  = (int)(filter_input(INPUT_GET, 'show', FILTER_VALIDATE_INT) ? $_GET['show'] : 8);
  $from  = (int)(filter_input(INPUT_GET, 'from', FILTER_VALIDATE_INT) ? $_GET['from'] : 0);

  $Category    = get_category_by_seo_name($name);                 // Get category
  $count       = get_article_count_by_category_seo_name($title);  // Get article count
  $articlelist = get_article_list($Category->id, $show, $from);   // Get list of articles
}

if ( (!$Category) OR (empty($article_list)) ) {
  header( 'Location: index.php' );
}

include 'includes/header.php'; 
?>

<div class="container_12 category">

  <h2 class="category-title"><?= $Category->title ?></h2>
  <p class="category-description"><?= $Category->description ?></h2>

  <?php foreach ($article_list as $Article) { ?>
      <div class="grid_4 article-link">
       <a href="<?= $Category->seo_name ?>/<?= $Article->seo_title ?>">
      <img src="<?= $Article->filepath ?>" 
           alt="<?= $Article->alt ?>" type="<?= $Article->mediatype ?>">
      <?=$Article->title?><br>
      <?php
      if ($logged_in && $Article->liked) {
        echo '<i class="fa fa-heart"></i>';
      } else {
        echo '<i class="fa fa-heart-o"></i>';
      }
      echo  $Article->like_count;
    ?>
    </a>
     <a href="<?= $Category->seo_name?>/<?= $Article->seo_title?>#comments">
    <i class="fa fa-comment-o"></i><?= $Article->comment_count?>
  </a>
      </div>
  <?php } ?>

</div>

<?php
  echo create_pagination($count, $show, $from);
  include 'includes/footer.php'; 
?>