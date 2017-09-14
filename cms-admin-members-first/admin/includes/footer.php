<footer>
  &copy; 2017
</footer>
</div><!-- /container -->
<script src="lib/jquery/jquery-1.12.4.min.js"></script>
<script src="lib/tinymce/js/tinymce/tinymce.min.js"></script>
<script src="lib/photoviewer/photo-viewer.js"></script>

<script>
  $(function() {
    if ($('#content').length){
      tinymce.init({
        selector: '#content',
        toolbar: 'styleselect, formatselect, bold, italic, alignleft, aligncenter, alignright, alignjustify, bullist, numlist, blockquote',
        plugins: "code"
      });
    }
    if ($('#description').length){
      tinymce.init({
        selector: '#description',
        toolbar: 'styleselect, formatselect, bold, italic, alignleft, aligncenter, alignright, alignjustify, bullist, numlist, blockquote',
        plugins: "code"
      });
    }
    $(".delete").click(function(){
      if (!confirm("Do you want to delete")){
        return false;
      }
    });
  });
</script>
</html>