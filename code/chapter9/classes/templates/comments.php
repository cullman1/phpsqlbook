<div class="accordion" id="accordion2">
    <div class="accordion-group">    
        <div class="accordion-heading">
            <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion2" href="#collapse{{comments.article_id}}">
                <img src="../../code/images/comments-xl.png" /> Comments: {{.TotalComments}}
            </a>
        </div>
        [[for]]
        <!--Content loop //-->
        <div id='collapse{{comments.article_id}}' class='accordion-body collapse'>
          <div class="accordion-inner">
            <div id="commentbox">
                {{comments.comment}}
                <br/> 
                <span class='small_name'><i> {{user.full_name}}</i></span> - <span class='small_name'> {{comments.comment_date}}</span> 
            </div> 
           <hr/> 
           <div id="AddComment">
              <a href='#' onclick="javascript:$('#comment_box').toggle();" >Add a comment</a>
           </div>
           <form id="form1" method="post" action="../pages/add-comment-text.php">
             <div id="comment_box" style="display:none;">
                <br/>
                <label for="commentText">Comment:</label>
                <textarea id="commentText" name="commentText"  class="collapsearea"  style="vertical-align:top; width: 400px; height: 80px;"></textarea>
                <button type="submit" class="btn btn-default">Submit Comment</button>
                <input id='articleid' name='articleid' type='hidden' value='{{comments.article_id}}'/>
             </div>
           </form>
                </div>
         </div>
         [[next]] 
   </div>
</div>