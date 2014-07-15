<div id="image2" class='modal modal-content modal-header fade' style="width:623px; overflow-x:hidden; overflow-y:hidden;height:675px;">
  <div>
    <div>
      <div>
        <a class='close' data-dismiss='modal'>&times;</a>
        <h4>Insert Image</h4>
        <ul class="nav nav-tabs">
          <li class="active">
            <a href="#upload-tab" data-toggle="tab" style="font-size:13px;">Upload</a>
          </li>
          <li>
            <a href="#upload-library" data-toggle="tab" style="font-size:13px;">Library</a>
          </li>
        </ul>
        <div class="tab-content" style="overflow-x:hidden; overflow-y:hidden;">
          <div class="tab-pane active" id="upload-tab">
            <form id="file" name="file" enctype="multipart/form-data" action="../uploads">
              <div class="panel-body">
                <div class="form-group">
                  <label for="uploader">Upload new item</label>
                  <input type="file" id="uploader" name="uploader" />
                  <br/>
                  <label for="title">Image title:</label>
                  <input id="title" name="title" type="text"/>
                </div>
                <div id="showprogress" style="visibility:hidden;">
                  <br/>
                  Progress: <progress  value="0" max="10" ></progress>
                </div>
              </div>
           
            <input id="upload-btn" class="btn btn-primary note-image-btn" value="Insert Image" type="button" />
          </div>
          <div class="tab-pane" id="upload-library">                
            <?php 
            /* Db Details */
            require_once('../includes/db_config.php');
            $select_mediauploaded_sql = "select media.media_id, media_title, file_type, url, thumbnail, name, date_uploaded FROM media where file_type='image/jpeg' OR file_type='image/png' OR file_type='image/gif'";
            $select_mediauploaded_result = $dbHost->query($select_mediauploaded_sql);
            if(!$select_mediauploaded_result) {      die("Query failed: ". mysql_error());} ?>
            <script type="text/javascript">
              $(document).ready(function(){
              $(".btn-clicked").on('click', function(){
                var buttonid = this.id;
                var buttonname = $("#"+buttonid).attr("data-url");
                buttonname2 = "../uploads/" + buttonname.substr(buttonname.lastIndexOf('=')+1,  (buttonname.length - buttonname.lastIndexOf('=')-1));
                var sHTML = '<img src=' + buttonname2 + ' />' ;
                var elem1 = document.getElementById("rich-text-container");
                var decoded = elem1.innerHTML;
                var new1 = decoded.replace(/"/g, '');  
                if(elem1.innerHTML != 'undefined')
                {
                    sHTML =  new1 + '<img src=' + buttonname2 + ' />' ;
                }
                var sHTML2 = $('#ArticleTitle').val();
       
                var _href =  $(this).attr("data-url");
                var url = window.location.search;
                _href=_href+url;
                $(this).attr("data-url", _href + '&ArticleTitle=' + sHTML2 + "&ArticleContent=" + sHTML);
                window.location.href = $(this).attr("data-url");
              });
              $("#upload-btn").on('click', function(){      
                    $('#showprogress').css("visibility","visible");
                    var formData = new FormData($('form')[0]); 
                $.ajax({
                url: '../includes/table.php',  //Server script to process data
                type: 'POST',
                xhr: function() {  // Custom XMLHttpRequest
                    var myXhr = $.ajaxSettings.xhr();
                    if(myXhr.upload){ // Check if upload property exists
                        myXhr.upload.addEventListener('progress',progressHandlingFunction, false); // For handling the progress of the upload
                    }
                return myXhr;
                },
        //Ajax events
        success: function(data, status) {
            $('#showprogress').css("visibility","hidden");
            $('#replacebody').html(data);
                var filename = document.getElementById("uploader").value;
                filename = filename.split(/(\\|\/)/g).pop();
                var sHTML = '<img src=../uploads/' + filename + ' />' ;
                var elem1 = document.getElementById("rich-text-container");
                var decoded = elem1.innerHTML;
                var new1 = decoded.replace(/"/g, '');  
                if(elem1.innerHTML != 'undefined')
                {
                    sHTML =  new1 + '<img src=../uploads/' + filename + ' />' ;
                }
                var sHTML2 = $('#ArticleTitle').val();
       
                var _href =  $(this).attr("data-url");
                var url = window.location.search;
                _href=_href+url;
                $(this).attr("data-url", _href + '&ArticleTitle=' + sHTML2 + "&ArticleContent=" + sHTML);
                window.location.href = $(this).attr("data-url");
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
  });
});

function progressHandlingFunction(e){
    if(e.lengthComputable){
        $('progress').attr({value:e.loaded,max:e.total});
    }
}
            </script>
            <div id="tab-container">
              <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                <!-- Indicators -->
                
                <ol class="carousel-indicators" style="position: relative; top: 400px; left:250px;">
                  <?php 
                    $loopCounter = 0;     
                    $totalRecords = mysql_num_rows($select_mediauploaded_result);
                    for ($i=$loopCounter; $i<$totalRecords; $i++)
                    { ?>
                  <li data-target="#carousel-example-generic" data-slide-to="<?php echo ($i); ?>" <?php if($i==0){echo "class='active'";} ?> ></li>
                  <?php   } ?>
                </ol>

                <!-- Wrapper for slides -->
                <div class="carousel-inner">
                  <?php
                    $innerCounter = 1;
                    while($select_mediauploaded_row = mysql_fetch_array($select_mediauploaded_result))
                    { ?>
                  <div class="item <?php if($innerCounter==1){echo "active";} ?>">
                    <img style="max-height:440px;" src='<?php echo $select_mediauploaded_row["url"]; ?>' alt='<?php echo $select_mediauploaded_row["media_title"]; ?>' />
                    <div class="carousel-caption" style="color:white; bottom: 45px;font-size: 15px;">
                      <?php echo $select_mediauploaded_row["media_title"]; ?>
                    </div>
                    <br/>
                    <br/>
                    <div  style="text-align:center; padding-top:60px;">
                      <button id="button<?php echo $select_mediauploaded_row["media_id"]?>"  type="button" data-url="<?php echo basename($_SERVER['PHP_SELF']);?>?pressed=<?php echo $select_mediauploaded_row["media_id"]?><?php if(isset($_REQUEST["article_id"])){echo "&article_id=".$_REQUEST["article_id"];} ?>&imgname=<?php echo $select_mediauploaded_row["name"]?>" class="btn-clicked btn btn-primary">Select this image</button>
                    </div>
                  </div>
                  <?php 
                  $innerCounter= $innerCounter+1;
                } ?>
                </div>

                <!-- Controls -->
                <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                  <span class="glyphicon glyphicon-chevron-left"></span>
                </a>
                <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
                  <span class="glyphicon glyphicon-chevron-right"  style="right:0;"</span>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
 <a data-toggle="modal" class="btn" title="Insert picture (or just drag & drop)" id="pictureBtn" href="#image2" tabindex="-1" ><i class="icon-picture"></i></a>
<!--<a data-toggle="modal" href="#image" class="btn btn-primary btn-large">Add Featured Image</a></div>//-->