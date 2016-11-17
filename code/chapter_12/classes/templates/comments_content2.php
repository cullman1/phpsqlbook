<div style="padding-left:10px;" class="accordion" id="accordion2">
  <div class="accordion-group">    
    <div class="accordion-heading" style="float:left; ">
      <a style="margin-bottom:15px;" class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion2" onclick="javascript:$('#collapse{{comments.article_id}}').toggle();">
        <img src="/phpsqlbook/code/chapter_12/assets/comments-xl.png" /> Comments: {{.Total}}
      </a>
      <input name='articleid' type='hidden' value='{{comments.article_id}}'/>
    </div>
    <div id="collapsed{{comments.article_id}}" class="accordion-body collapse" >
      <div class="accordion-inner">   
        &nbsp;&nbsp;&nbsp;<u><a onclick="javascript:$('#comment_box{{comments.article_id}}').toggle();">Add a new comment</a></u>
        <form id="form{{comments.id}}" method="post"  action="/phpsqlbook/comments/add_comment?id={{comments.article_id}}">
          <div id="comment_box{{comments.article_id}}" style="display:none;"><br/>
            <label for="commentText">Comment:</label>
            <textarea id="commentText{{comments.id}}" name="commentText" class="collapsearea" class="height"/></textarea>
            <button type="submit" class="btn btn-default">Submit Comment</button>
          </div>
        </form>
        </div><br/> 
        <div id='collapse{{comments.article_id}}' class="accordion-body collapse" style="display:none;">
          [[for]]
          <div class="accordion-inner">
            <div id="commenterbox{{comments.id}}" style="float:left; ">
              <span class='small_name'>{{comments.comment}}</span> 
              <span class='small_name'><i> {{user.forename}} {{user.surname}}</i></span> 
              <span class='small_name'> {{comments.posted}}</span>
            </div>
            &nbsp;&nbsp;<u><a onclick="javascript:$('#comment_box{{comments.id}}').toggle();">Reply to this comment</a></u>
           <form id="form{{comments.id}}" method="post" action="/phpsqlbook/comments/add_comment?id={{comments.article_id}}&comment={{comments.id}}">
             <div id="comment_box{{comments.id}}" style="display:none;"><br/>
               <label for="commentText">Comment:</label>
               <textarea id="commentText{{comments.id}}" name="commentText" class="collapsearea height"/></textarea>
               <button type="submit" class="btn btn-default">Submit Comment</button>
             </div>
           </form>
         </div>
         [[next]]
