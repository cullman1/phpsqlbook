<div class="content-page">
  <h3 style="text-align:left;"><u><a href="<?php echo $GLOBALS["root"]; ?><?php echo $object->name ?>/<?php echo $object->seo_title ?>"><?php echo $object->title ?></a></u>  </h3>
  <?php if ($object->template != 'general') {  ?>
    <h5><?php echo $object->published ?></h5>
    <a href="<?php echo $GLOBALS['root']; ?>author/<?php echo $object->forename ?>-<?php echo $object->surname ?>"><?php echo $object->forename ?> <?php echo $object->surname ?></a><br/><br/>
  <?php } ?>
  <div class="box" style="width:800px;"><?php echo $object->content ?></div><br/>
    <?php if ($object->template != 'general') {  ?>
      <?php if ( isset($_SESSION['user_id'])) { ?>
    <?php echo get_like_button($_SESSION['user_id'], $object->id); ?>  
  <?php } else {
            echo '    <i class="fa fa-heart-o" aria-hidden="true"></i>  ';    
            }?>
      <?php echo  $object->like_count; ?>  
  <div class="comment-total"><?php echo '<i class="fa fa-comment-o" aria-hidden="true"></i> '.$object->comment_count; ?></div>
    <?php } ?>
  <?php if (($object->template != 'general')  &&  (basename($_SERVER['PHP_SELF'])=="article.php")) { 
    echo get_comments_array($object->id);     
  } ?>
</div><br/>