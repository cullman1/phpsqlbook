    <?php  
    
    /* comments accordion */
    while($select_totalcomments_row = $select_totalcomments_result->fetch()) 
    { ?>
    <div class="accordion" id="accordion2">
      <div class="accordion-group">
        <div class="accordion-heading">
          <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse<?php echo $loopCount; ?>">
            <img src="../assets/comments-xl.png"/> 
            <?php 
            echo $select_totalcomments_row['TotalComments'];
            if ($select_totalcomments_row['TotalComments']==1) {
              echo " comment";
            }
            else
            {
              echo " comments";
            }
            ?>
          </a>
        </div>
        <div id='collapse<?php echo $loopCount; ?>' class='accordion-body collapse <?php  if (isset($_REQUEST["showcomments"])) { if ($row["article_id"] == $_REQUEST["showcomments"]) { echo "in"; }}?>'>
          <div class="accordion-inner">
            <?php 
        $select_comments_rows = $select_comments_result->fetchAll();
        $num_rows = count($select_comments_rows);   
        if ($num_rows!=0) 
            { ?>
            <div id="TotalComments"><b>All comments</b> <?php if (!isset($_SESSION['authenticated'])) { ?> <b>Login to leave a comment</b> <?php } ?> <hr/></div> 
          <?php } 
            include('../includes/comments-list.php');
          ?>
            <div id="AddComment">
              <a href='../pages/add-comment.php?articleid=<?php echo $row["article_id"]; ?>'>Add a comment</a>
            </div>
            <?php  if (isset($_REQUEST["showcomments"])) { 
              if($_REQUEST["showcomments"] ==  $row["article_id"]) { ?>
                <form id="form1" method="post" action="../pages/add-comment-text.php?page=<?php echo $currPage; ?>">
                  <div>
                    <br/>
                    <label for="commentText" >Comment:</label>
                    <textarea id="commentText" name="commentText"  class="collapsearea"  style="vertical-align:top; width: 400px; height: 80px;"></textarea>
                    <button type="submit" class="btn btn-default">Submit Comment</button>
                    <input id='articleid' name='articleid' type='hidden' value='<?php echo $row["article_id"]; ?>'/>
                  </div>
                </form>
        <?php  } 
            } ?>
          </div>
        </div>
      </div> 
    </div>

    <?php 
    } ?>