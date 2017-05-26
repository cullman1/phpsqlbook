
<a id="link{{id}}" href="#">Add a comment</a>
<form id="form{{id}}" method="post" style="display:none;"
action="__ROOT/comments/add_comment?id={{articleId}}
        &reply=0" >
  <label for="comment">Comment:</label>
  <textarea id="comment{{id}}" name='comment'></textarea>
  <button type="submit" >Submit Comment</button>
</form>
<script>
$("#link{{id}}").click(function() { 
  $("#form{{id}}").toggle(); 
});
</script>


