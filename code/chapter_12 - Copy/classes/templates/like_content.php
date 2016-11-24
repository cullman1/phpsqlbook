
  <form id="likeform" method="post" style="padding-left:10px; float:left;" action="<?php echo "http://".$_SERVER['HTTP_HOST']; ?>/phpsqlbook/login/likes?user_id={{.userid}}&article_id={{.articleid}}&liked={{.likes_count}}">
    <span class="left">{{.likes_total}} users like this article</span>   
    <input name="like_button" type="submit" value='Like/Unlike this article'  />
  </form>
  <div style="clear:both"></div>
