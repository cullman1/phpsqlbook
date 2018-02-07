<?php
require_once dirname(__DIR__) .'/../config.php';
$cms->userManager->redirectNonAdmin();
?>
<footer>
  &copy; <?php echo date("Y"); ?>
  <a href="system-info.php">System info</a>
</footer>
<script src="https://code.jquery.com/jquery-3.2.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>

<?php
if (isset($_GET['include'])) { 
 if($_GET['include']=="croppie") {
 include dirname(__DIR__) . '/../includes/modal-window.php'; 
}
} ?>
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