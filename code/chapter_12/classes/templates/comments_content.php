<div style="margin-left:10px"><img src="/phpsqlbook/code/chapter_12/assets/comments-xl.png" /> Comments: {{comment.commentcount}}
<a href="#">Add a comment</a>
      <form id="commentform{{comments.id}}" method="post"  action="/phpsqlbook/comments/add_comment?id={{comments.article_id}}">
            <label for="commentText">Comment:</label>
            <textarea id="commentText{{comments.id}}" name="commentText" class="collapsearea" class="height"/></textarea>
            <button type="submit" class="btn btn-default">Submit Comment</button>
        </form></div>
  [[for]]
            <div id="commenterbox{{comments.id}}" style="margin-left:10px">
              <span class='small_name'>{{comments.comment}}</span> 
              <span class='small_name'><i> {{user.forename}} {{user.surname}}</i></span> 
              <span class='small_name'> {{comments.posted}}</span>
            </div>
          [[next]]
  