<?php  
      error_reporting(E_ALL | E_WARNING | E_NOTICE);
      ini_set('display_errors', TRUE);
      include '../includes/header.php' ?>
  <form id="file" name="file" enctype="multipart/form-data">
      <div class="panel panel-default">
        <div class="panel-body">
          <form role="form">
            <div class="form-group">
              <label for="uploader">Upload new item</label>
              <input type="file" id="uploader" name="uploader">
              <br/>
              <label for="title">Image title:</label>
              <input id="title" name="title" type="text"/> 
            </div>
            <input id="upld" type="button" class="btn btn-default" value="Upload"/>
     <script>
         $("#upld").click(function () {
             $("#Status_Post").css("visibility", "hidden");
             $('#showprogress').css("visibility", "visible");
             var formData = new FormData($('form')[0]);
             $.ajax({
                 url: 'table1.php',  //Server script to process data
                 type: 'POST',
                 xhr: function () {  // Custom XMLHttpRequest
                     var myXhr = $.ajaxSettings.xhr();
                     if (myXhr.upload) { // Check if upload property exists
                         myXhr.upload.addEventListener('progress', progressHandlingFunction, false); // For handling the progress of the upload
                     }
                     return myXhr;
                 },
                 //Ajax events
                 success: function (data, status) {
                     $('#showprogress').css("visibility", "hidden");
                     $('#Status_Post').css("visibility", "visible");
                     $('#replacebody').html(data);
                     $("#Status_Post").html(" <br/><span class='red' style='color:red;'>Item successfully added!</span>");
                 },
                 error: function (xhr, desc, err) {
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
         function progressHandlingFunction(e) {
             if (e.lengthComputable) {
                 $('progress').attr({ value: e.loaded, max: e.total });
             }
         }
            </script>
          </form>
          <div id="showprogress" style="visibility:hidden;">
            <br/>
            Progress: <progress  value="0" max="10" ></progress>
           </div>
             <div id="Status_Post">
              <br/>
             </div>
        </div>
      </div>
    </form>
      <table class="table table-hover">
        <thead>
          <tr>
            <th>Id</th>
            <th>Thumbnail</th>
             <th>Linked article(s)</th>
             <th>Title</th>
            <th>File name</th>
            <th>File type</th>
      
          </tr>
        </thead>
        <tbody id="replacebody">
          <?php include 'table1.php' ?>
        </tbody>      
      </table>
<?php include '../includes/footer.php' ?>
