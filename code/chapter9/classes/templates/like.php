<div id="accordion3">
    <div class="accordion-group">
         <form id="likeform" method="post" action="../../code/includes/submit-like.php?user_id=<?php echo $_REQUEST["user_id"]; ?>&article_id=<?php echo $_REQUEST["article_id"]; ?>&liked=<?php echo $_REQUEST["liked"]; ?>">
            <div> 
                <span style="margin-left:10px;"><?php echo $_REQUEST["likes"]; ?> users like this article</span>   
                <input id="like_button" name="like_button" type="submit" value="Like"  />
            </div>
         </form>
   </div>
</div>
<div id="results-box">

</div>
