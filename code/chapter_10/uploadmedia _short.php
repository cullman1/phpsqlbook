<?php  
      error_reporting(E_ALL | E_WARNING | E_NOTICE);
      ini_set('display_errors', TRUE);
      include '../includes/header.php' ?>
  <form id="file" name="file" enctype="multipart/form-data">
              <label for="uploader">Upload new item
              <input type="file" id="uploader" name="uploader"></label>
              <label for="title">Image title:</label>
              <input id="title" name="title" type="text"/> 
            <input id="upld" type="button" class="btn btn-default" value="Upload"/></label>
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
                         myXhr.upload.addEventListener('progress', progressHandlingFunction, false); 
                     }
                     return myXhr;
                 },
                 success: function (data, status) {
                     $('#showprogress').css("visibility", "hidden");
                     $('#Status_Post').css("visibility", "visible");
                     $('#replacebody').html(data);
                     $("#Status_Post").html(" <br/><span class='red' style='color:red;'>Item successfully added!</span>");
                 },
                 error: function (xhr, desc, err) {
                     alert("Details: " + desc + "\nError:" + err);
                 },
                 data: formData,
                 processData: false
             });
         });
         function progressHandlingFunction(e) {
             if (e.lengthComputable) {
                 $('progress').attr({ value: e.loaded, max: e.total });
             }
         }
            </script>
          <div id="showprogress" style="visibility:hidden;">
            Progress: <progress  value="0" max="10" ></progress>
           </div>
         <div id="Status_Post"></div>
    </form>
    <?php include 'table2.php' ?>
<?php include '../includes/footer.php' ?>
