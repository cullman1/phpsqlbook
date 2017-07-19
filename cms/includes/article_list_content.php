<div class="content-box">
<?php if (!isset( $Article->thumb) ) {
$Article->thumb = "uploads/blank_article.png";
} ?>
 <h3 class="heading"><a href="<?= $GLOBALS["root"] ?><?= $Article->name ?>/<?= $Article->seo_title ?>"><?= $Article->title ?></a></h3>
  <img src="<?= $Article->thumb ?>" 
           alt="<?= $Article->alt ?>" type="<?= $Article->mediatype ?>"> <br>
       <?php 
        echo '<i class="fa ';
        if ( isset($_SESSION['user_id']) && ($Article->liked) ) { 
          echo 'fa-heart">';
        } else {
          echo 'fa-heart-o">';
        }
        echo '</i> '; 
        echo $Article->like_count;
      ?>  

    </a>

<?php echo '<a href="' . $GLOBALS["root"] . $Article->name . '/'. $Article->seo_title.'#comments"><i class="fa fa-comment-o show" aria-hidden="true"></i> '.$Article->comment_count .'</a>'; ?>
</div>