
  <form id="likeform" method="post" action="<?php echo "http://".$_SERVER['HTTP_HOST']; ?>/cmsfull/login/likes/1?user_id={{.userid}}&article_id={{.articleid}}&liked={{.likes_count}}">
    <span class="left">{{.likes_total}} users like this article</span>   
    <input name="like_button" type="submit" value='Like/Unlike this article'  />
  </form>
