<div id="accordion3">
    <div class="accordion-group">
         <form id="likeform" method="post" action="../../code/includes/submit-like.php?user_id={{.userid}}&article_id={{.articleid}}&liked={{.likes_total}}">
            <div> 
                <span style="margin-left:10px;">{{.likes_count}} users like this article</span>   
                <input id="like_button" name="like_button" type="submit" value='Like/Unlike this article'  />
            </div>
         </form>
   </div>
</div>
