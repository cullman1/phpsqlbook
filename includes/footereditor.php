


    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
   
    <script>
$(document).ready(function() {
  $('#summernote').summernote({
  height: 300,   //set editable area's height
  focus: true ,   //set focus editable area after Initialize summernote
  oninit: function(){
    $('<div class="note-file btn-group"><button id="saveFileBtn" type="submit" class="btn btn-default btn-sm btn-small" data-tooltip data-original-title="Save" data-event="something" data-placement="bottom" tabindex="-1" onclick="$(\'#saveFileBtn\').removeClass(\'btn-danger\');$(\'#block\').css({\'display\':\'block\'})"><i class="fa fa-save"></i></button></div>').prependTo($('.note-toolbar'))}
});
});
</script>
  </body>
</html>