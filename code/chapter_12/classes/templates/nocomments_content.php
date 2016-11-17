<div  style="padding-left:10px;" class="accordion" id="accordion2">
 <div class="accordion-group">    
  <div class="accordion-heading"  style="float:left; ">
   <a style="margin-bottom:15px;" class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion2" >
    <img src="/phpsqlbook/code/chapter_12/assets/comments-xl.png" /> Comments: 0 
   </a>
   <input id='articleid' name='articleid' type='hidden' value='{{article.id}}'/>
  </div>
  <div id="collapsedr{{article.id}}" class='accordion-body collapse'>
   <div id='collapse{{.random}}' >
     <div class="accordion-inner">     
      &nbsp;&nbsp;&nbsp;<u><a href='#' onclick="javascript:$('#comment_box{{.random}}').toggle();" >Add a new comment</a></u>         
       <form id="form{{.random}}" method="post" action="/phpsqlbook/comments/add_comment?id={{article.id}}">
         <div id="comment_box{{.random}}" style="display:none;">
          <br/>
         <label for="commentText">Comment:</label>
         <textarea id="commentText{{.random}}" name="commentText" class="collapsearea positioning"></textarea>
         <button type="submit" class="btn btn-default">Submit Comment</button>
             </div>
           </form>
          </div><br/>
         </div>
        </div>
     </div>
   </div>