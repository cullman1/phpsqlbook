<div style="margin-left:10px"><img src="/phpsqlbook/code/chapter_12/assets/comments-xl.png" /> Comments: {{commentCount}}
 <a id="link{{id}}" href="#">Add a comment</a>
 <form id="form{{id}}" method="post"  action="/phpsqlbook/comments/add_comment?id={{articleId}}&comment={{id}}" style="display:none;">
  <label for="commentText">Comment:</label>
  <textarea id="commentText{{id}}" name="commentText" class="collapsearea" class="height"/></textarea>
  <button type="submit" class="btn btn-default">Submit Comment</button>
 </form>
 <script>
 $( "#link{{id}}" ).click(function() {
  $( "#form{{id}}" ).toggle();
});
</script>
</div>
[[for]]
 <div id="commenterbox{{id}}" style="margin-left:10px">
  <span class='small_name'>{{comment}}</span> 
  <span class='small_name'><i> {{author}}</i></span> 
  <span class='small_name'> {{posted}}</span>
 </div>
[[next]]
