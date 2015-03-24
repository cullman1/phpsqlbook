<div class="accordion" id="accordion{{.article_id}}">
    <div class="accordion-group">    
        <div class="accordion-heading">
            <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion2" href="#collape{{.article_id}}">
                <img src="../../code/images/comments-xl.png" /> Comments: {{.TotalComments}}
            </a>
                   
        </div>
        <div id="collape{{.article_id}}" class='accordion-body collapse'>
        [[for]]
        <!--Content loop //-->
        <div id='collapse{{comments.comments_id}}' >
          <div class="accordion-inner">
            <div id="commenterbox{{comments.comments_id}}">
                {{comments.comment}}
                <br/> 
                <span class='small_name'><i> {{user.full_name}}</i></span> - <span class='small_name'> {{comments.comment_date}}</span> 
            </div> 
           <hr/> 
           <div id="AddComment">
              <a  onclick="javascript:$('#comment_box{{comments.comments_id}}').toggle();" >Add a comment</a>
           </div>
           <form id="form{{comments.comments_id}}" method="post" action="../code/includes/add-comment-text.php">
             <div id="comment_box{{comments.comments_id}}" style="display:none;">
                <br/>
                <label for="commentText">Comment:</label>
                <textarea id="commentText{{comments.comments_id}}" name="commentText"  class="collapsearea"  style="vertical-align:top; width: 400px; height: 80px;"></textarea>
                <button type="submit" class="btn btn-default">Submit Comment</button>
                <input id='articleid' name='articleid' type='hidden' value='{{.article_id}}'/>
             </div>
           </form>
          </div>
         </div>
         [[next]] 
            </div>
   </div>
</div>