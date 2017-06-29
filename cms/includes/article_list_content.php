<div class="content-box">
<?php if (!isset( $object->thumb) ) {
$object->thumb = "uploads/blank_article.png";
} ?>
  <img src="../<?php echo $object->thumb ?>" />
 <h3 class="heading"><a href="<?= $GLOBALS["root"] ?><?= $object->name ?>/<?= $object->seo_title ?>"><?= $object->title ?></a></h3>
 <?php 
    echo '<a href="' . $GLOBALS["root"] .  $object->name  . '/'. $object->seo_title . '">';
    if ( isset($_SESSION['user_id'])) { 
      echo get_like_button( $object->id,$object->liked,1) . '</a> ';
    } else {
      echo '<i class="fa fa-heart-o" aria-hidden="true"></i></a> ';
    }
    echo  $object->like_count;  ?>  
<?php echo '<a href="' . $GLOBALS["root"] . $object->name . '/'. $object->seo_title.'#comments"><i class="fa fa-comment-o show" aria-hidden="true"></i> '.$object->comment_count .'</a>'; ?>
</div>