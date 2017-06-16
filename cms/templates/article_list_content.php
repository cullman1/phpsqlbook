<div style="display:block;float:left; padding: 10px;  ">
  <img src="../<?php echo $object->thumb ?>" />
  <h3 class="heading"><a href="<?= $GLOBALS["root"] ?><?= $object->name ?>/<?= $object->seo_title ?>"><?= $object->title ?></a></h3>

  <?php if ( isset($_SESSION['user_id'])) { 
            echo get_like_button($object->liked, $_SESSION["user_id"], $object->id); 
        } else {
          echo '<i class="fa fa-heart-o" aria-hidden="true"></i> ';
        }
        echo  $object->like_count; ?>  
<?= '<i style="padding-left:90px;" class="fa fa-comment-o" aria-hidden="true"></i> '.$object->comment_count; ?>
</div>