<div class="content-page">

  <?php if ($object->template != 'general') {  ?>
  <img src="../../<?php echo $object->thumb ?>" />
  <?php } ?>
      <h3 style="text-align:left;"><u><a href="<?php echo $GLOBALS["root"]; ?><?php echo $object->name ?>/<?php echo $object->seo_title ?>"><?php echo $object->title ?></a></u>  </h3>
    <?php if ($object->template != 'general') {  ?>
      <?php if ( isset($_SESSION['user_id'])) { ?>
    <?php echo   get_like_button($object->liked, $_SESSION["user_id"], $object->id); 
  <?php } else {
            echo '    <i class="fa fa-heart-o" aria-hidden="true"></i>  ';    
            }?>
      <?php echo  $object->like_count; ?>  
      <div class="comment-total"><?php echo '<i class="fa fa-comment-o" aria-hidden="true"></i> '.$object->comment_count; ?></div>
    <?php } ?>

</div><br/>