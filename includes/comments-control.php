    <?php  
    
    /* comments accordion */
    while($select_totalcomments_row = mysql_fetch_array($select_totalcomments_result)) 
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
            <?php if (mysql_num_rows($select_comments_result)!=0) 
            { ?>
            <div id="TotalComments"><b>All comments</b>  <hr/></div> 
          <?php } 
            include('../includes/comments-list.php');
          ?>
            <div id="AddComment">
              <a href='../pages/addcomment.php?articleid=<?php echo $row["article_id"]; ?>'>Add a comment</a>
            </div>
            <?php  if (isset($_REQUEST["showcomments"])) { 
              if($_REQUEST["showcomments"] ==  $row["article_id"]) { ?>
                <form id="form1" method="post" action="../pages/addcommenttext.php?page=<?php echo $currPage; ?>">
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