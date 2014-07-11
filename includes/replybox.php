<div id="commentbox">
  <?php echo $row3[0]['comment'];  ?> 
  <br/> 
  <span class='small_name'><i> <?php echo $row3[0]['user_name'];  ?></i></span> - <span class='small_name'> <?php echo $row3[0]['comment_date'];  ?></span> 
  <?php if (isset($_SESSION['authenticated'])) { ?>  <button id="replybutton<?php echo $row["article_id"]; echo $row3[0]["comments_id"]; ?>" type="button"  class="btn btn-default">Reply</button> <?php } ?>
      
  <!--Submit reply box-->
  <form id="form<?php echo $row["article_id"];echo $row3[0]["comments_id"]; ?>" method="post" action="../pages/add-comment-text.php?page=<?php echo $currPage; ?>&commentid=<?php echo $row3[0]["comments_id"]; ?>" style="display:none;">
    <div>
      <br/>
      <label for="commentText2" >Reply:</label>
      <textarea id="commentText2" name="commentText"  class="collapsearea"  style="vertical-align:top; width: 400px; height: 80px;"></textarea>
      <button type="submit" class="btn btn-default">Submit Reply</button>
      <input id='articleid2' name='articleid2' type='hidden' value='<?php echo $row["article_id"]; ?>'/>
    </div>
  </form>
  <script>
    $('#replybutton<?php echo $row["article_id"]; echo $row3[0]["comments_id"]; ?>').click(function(){
      if($('#form<?php echo $row["article_id"]; echo $row3[0]["comments_id"]; ?>').css('display')=="none")
      {
        $('#form<?php echo $row["article_id"]; echo $row3[0]["comments_id"];?>').css("display","block");
      }
      else 
      {
        $('#form<?php echo $row["article_id"]; echo $row3[0]["comments_id"];?>').css("display","none");
      }
    });
  </script>
  <hr/>
</div>
<?php
if (isset($row3[0]['children']))
{
  $row3 = $row3[0]['children']; ?>

    <div style="padding-left:20px;">
      <?php include("../includes/replybox.php"); ?>
    </div>
<?php }
?>