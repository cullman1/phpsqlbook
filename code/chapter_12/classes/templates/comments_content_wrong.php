<div style="margin-left:10px"><img src="/phpsqlbook/code/chapter_12/assets/comments-xl.png" /> Comments: {{.Total}}
  [[for]]
            <div id="commenterbox{{comments.id}}" style="margin-left:10px">
              <span class='small_name'>{{comment}}</span> 
              <span class='small_name'><i> {{user.forename}} {{user.surname}}</i></span> 
              <span class='small_name'> {{posted}}</span>
            </div>
          [[next]]
        <form id="form{{comments.id}}" method="post"  action="/phpsqlbook/comments/add_comment?id={{articleId}}">
            <label for="commentText">Comment:</label>
            <textarea id="commentText{{id}}" name="commentText" class="collapsearea" class="height"/></textarea>
            <button type="submit" class="btn btn-default">Submit Comment</button>
        </form></div>