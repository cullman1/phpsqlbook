  <div class="accordion" id="accordion2">
      <div class="accordion-group">
        <div class="accordion-heading">
          <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse{{comments.article_id}}">
            <img src="../../code/images/comments-xl.png" /> 
            Comments: {{.TotalComments}}
          </a>
        </div>
        <div id='collapse{{comments.article_id}}' class='accordion-body collapse in'>
          <div class="accordion-inner">
            <div id="commentbox">
                {{comments.comment}}
                <br/> 
                    <span class='small_name'><i> {{user.full_name}}</i></span> - <span class='small_name'> {{comments.comment_date}}</span> 
             </div> 
                <hr/> 
            </div>
            <div id="AddComment">
              <a href='../pages/add-comment.php?articleid={{comments.article_id}}'>Add a comment</a>
            </div>
                <form id="form1" method="post" action="../pages/add-comment-text.php">
                  <div>
                    <br/>
                    <label for="commentText" >Comment:</label>
                    <textarea id="commentText" name="commentText"  class="collapsearea"  style="vertical-align:top; width: 400px; height: 80px;"></textarea>
                    <button type="submit" class="btn btn-default">Submit Comment</button>
                    <input id='articleid' name='articleid' type='hidden' value='{{comments.article_id}}'/>
                  </div>
                </form>
          </div>
          </div>
      </div>
    
