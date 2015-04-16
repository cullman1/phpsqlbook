<div class="accordion" id="accordion2">
    <div class="accordion-group">    
        <div class="accordion-heading">
            <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion2" href="#collape{{article.article_id}}">
                <img src="../../code/images/comments-xl.png" /> Comments: 0 - Be the first to comment
            </a>
                   <input id='articleid' name='articleid' type='hidden' value='{{article.article_id}}'/>
        </div>
        <div id="collape{{article.article_id}}" class='accordion-body collapse'>
     
        <!--Content loop //-->
        <div id='collapse{{.random}}' >
          <div class="accordion-inner">    
           <hr/> 
           <div id="AddComment">
              <a href='#' onclick="javascript:$('#comment_box{{.random}}').toggle();" >Add a comment</a>
           </div>
           <form id="form{{.random}}" method="post" action="../pages/add-comment-text.php">
             <div id="comment_box{{.random}}" style="display:none;">
                <br/>
                <label for="commentText">Comment:</label>
                <textarea id="commentText{{.random}}" name="commentText"  class="collapsearea"  style="vertical-align:top; width: 400px; height: 80px;"></textarea>
                <button type="submit" class="btn btn-default">Submit Comment</button>
         
             </div>
           </form>
                </div>
         </div>
            </div>
   </div>
</div>