<div id="accordion3">
    <div class="accordion-group">
         <form id="likeform" method="post" action="includes/submit-like.php?user_id=<?php echo $_REQUEST["user_id"]; ?>&article_id=<?php echo $_REQUEST["article_id"]; ?>">
            <div> 
                <span style="margin-left:10px;"><?php echo $_REQUEST["likes"]; ?> users like this article</span>   
                <input id="like_button" name="like_button" type="button" value="Like"  />
            </div>
         </form>
   </div>
</div>
<script type="text/javascript">
function submitLike() {
    var formData = new FormData($('#likeform')); 
    
     $.ajax({
      url: '../includes/submit-like.php?user_id=<?php echo $_REQUEST["user_id"]; ?>&article_id=<?php echo $_REQUEST["article_id"]; ?>',  //Server script to process data
      type: 'POST',
      xhr: function() {  // Custom XMLHttpRequest
        var myXhr = $.ajaxSettings.xhr();
        return myXhr;
      },
      //Ajax events
      success: function(data, status) {
        if ($('#like_button').attr('value')=="Like") {
            $('#like_button').attr('value','Liked');
        }
        else {
             $('#like_button').attr('value','Like');
        }
      },
        error: function(xhr, desc, err) {
          console.log(xhr);
          alert("Details: " + desc + "\nError:" + err);
        },
        // Form data
        data: formData,
        //Options to tell jQuery not to process data or worry about content-type.
        cache: false,
        contentType: false,
        processData: false
    });            
}

var elLikeButton = document.getElementById("like_button");
elLikeButton.onclick = submitLike;
</script>
