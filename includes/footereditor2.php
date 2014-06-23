


    </div> <!-- /container -->

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
   
    <script>
      
      function overrideInsertImage() {
 
     var gm3 = "";
$.get('../includes/gallerymodal2.php', function(data) {
  gm3 = data;
  $(gm3).appendTo('#body').modal('show');

});
   
       return false;
      
    
  };
$(document).ready(function() {



$('#some-textarea').wysiwyg();




});
</script>
  </body>
</html>