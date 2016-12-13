
  <form id="likeform" method="post" style="padding-left:10px; float:left;" 
action="/phpsqlbook/login/likes?user={{.userid}}&article={{.articleid}}&liked={{.likes_count}}">
    <span class="left">{{.likes_total}} user(s) like this article</span>   
    <input name="like_button" type="submit" value='Like/Unlike this article'  />
  </form>
  <div style="clear:both"></div>
