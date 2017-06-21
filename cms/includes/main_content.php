<div class="content-box">
  <h3 class="heading"><a href="<?= $GLOBALS["root"]; ?><?= $object->name ?>/<?= $object->seo_title ?>"><?= $object->title ?></a></h3>
  <?php if ($object->template != 'general') {  ?>
    <h5><?= $object->published ?></h5>
    <a href="<?= $GLOBALS['root']; ?>author/<?= $object->forename ?>-<?= $object->surname ?>"><?= $object->forename ?> <?= $object->surname ?></a><br/><br/>
  <?php } ?>
 <?php echo $object->content ?><br/><br/>
    <?php if ($object->template != 'general') {  ?>
      <?php if ( isset($_SESSION['user_id'])) { ?>
    <?php  echo get_like_button($object->liked, $_SESSION["user_id"], $object->id);  ?>  
  <?php } else {
            echo '    <i class="fa fa-heart-o" aria-hidden="true"></i>  ';    
            }?>
      <?= $object->like_count; ?>  
  <?= '<i class="fa fa-comment-o" aria-hidden="true"></i> '.$object->comment_count; ?>
    <?php } ?>
  <?php if (($object->template != 'general')  &&  (basename($_SERVER['PHP_SELF'])=="article.php")) { 
    echo get_comments_list($object->id);     
  } ?>
</div><br/>