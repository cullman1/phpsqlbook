
<div style="margin-left:10px"><img src="/phpsqlbook/code/chapter_12/assets/comments-xl.png" /> Comments: {{commentCount}}
<a id="link{{id}}" href="#">&nbsp;Add a comment</a></div>
<form id="form{{id}}" method="post" style="display:none;" action="/phpsqlbook/comments/add_comment?id={{articleId}}&reply=0" >
  <label for="comment">Comment:</label>
  <textarea id="comment{{id}}" name="comment"></textarea>
  <button type="submit" >Submit Comment</button>
</form>
<script>
    $("#link{{id}}").click(function () {
        $("#form{{id}}").toggle();
    });
</script>
[[for]]
  <div id="commenterbox{{id}}" class="comment-box">
    <span class='small_name'>{{comment}}</span> 
    <span class='small_name'><i>{{author}}</i></span> 
    <span class='small_name'>{{posted}} </span>
  </div>
  <div>&nbsp;
    <a id="linker{{id}}" href="#" class="lnk"><u>Reply to a comment</u></a>
  </div>
  <form id="former{{id}}" method="post" action="/phpsqlbook/comments/add_comment?id={{articleId}}&reply={{id}}" style="display:none;">
    <div id="comment_box{{id}}" ><br/>
     <label for="comment">Comment:</label>
     <textarea id="Textarea1" name="comment" class="collapsearea height"/></textarea>
     <button type="submit" class="btn btn-default">Submit Comment</button>
    </div>
  </form>
  <script>
      $("#linker{{id}}").click(function () {
          $("#former{{id}}").toggle();
      });
  </script>
[[next]]