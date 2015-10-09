<div class="accordion" id="accordion2">
 <div class="accordion-group">    
  <div class="accordion-heading">
   <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion2"  href="#collapsed{{comments.article_id}}">
    <img src="/cms/assets/comments-xl.png" /> Comments: {{.ComTotal}}
   </a>
   <input name='articleid' type='hidden' value='{{comments.article_id}}'/>
  </div>
  <div id="collapsed{{comments.article_id}}" class='accordion-body collapse'>
[[for]]
    <div id='collapse{{comments.comments_id}}' >
     <div class="accordion-inner">
      <div id="commenterbox{{comments.comments_id}}">{{comments.comment}} <br/> 
       <span class='small_name'><i> {{user.full_name}}</i></span> - 
       <span class='small_name'> {{comments.comment_date}}</span> 
      </div> 
         <a onclick="javascript:$('#comment_box{{comments.comments_id}}').toggle();">Add a comment</a>
     <form id="form{{comments.comments_id}}" method="post" action="/cms/comments/add_comment/{{comments.article_id}}">
      <div id="comment_box{{comments.comments_id}}" style="display:none;"><br/>
       <label for="commentText">Comment:</label>
       <textarea id="commentText{{comments.comments_id}}" name="commentText"  class="collapsearea" class="height"/></textarea>
       <button type="submit" class="btn btn-default">Submit Comment</button>
      </div>
     </form>
     </div> 
     </div>
 [[next]] 