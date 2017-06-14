<div class="content-page">
  <img src="../<?php echo $object->thumb ?>" />
  <h3 class="heading"><a href="<?php echo $GLOBALS["root"]; ?><?php echo $object->name ?>/<?php echo $object->seo_title ?>"><?php echo $object->title ?></a></h3>
  <?php if ( isset($_SESSION['user_id'])) { 
            echo get_like_button($_SESSION['user_id'], $object->id); 
        } else {
          echo ' <i class="fa fa-heart-o" aria-hidden="true"></i> ';    
        }
        echo  $object->like_count; ?>  
  <div class="comment-total"><?php echo '<i class="fa fa-comment-o" aria-hidden="true"></i> '.$object->comment_count; ?></div>
</div><br/>