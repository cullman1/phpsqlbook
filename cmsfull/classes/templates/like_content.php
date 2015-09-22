<div id="accordion3">
 <div class="accordion-group">
  <form id="likeform" method="post" action="pages/submit-like.php?user_id={{.userid}}&article_id={{.articleid}}&liked={{.likes_total}}">
   <div> 
    <span class="left">{{.likes_count}} users like this article</span>   
    <input name="like_button" type="submit" value='Like/Unlike this article'  />
   </div>
  </form>
 </div>
</div>