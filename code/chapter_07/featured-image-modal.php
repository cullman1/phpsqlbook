 <a data-toggle="modal" href="#image" class="btn"> <i class="icon-picture"></i></a>
 <?php $statement = $dbHost->prepare("select * FROM media where file_type='image/jpeg' OR file_type='image/png' OR file_type='image/gif'");
  $statement->execute(); ?>
<script type="text/javascript">
  $(document).ready(function () {
    $(".btn-clicked").click(function () {
      $("#image").modal('hide');
    });
    $(".radio_pos").click(function () {
      var el = document.getElementById("rich-text-container");
      var txt = el.innerHTML;
      txt = txt.replace(/"/g, '');
      el.innerHTML =  txt + " <img width=100 src='../uploads/" + $(this).val() + "'>";
      $("#image").modal('hide');       
    });
  });
</script>
 <div id="image" class="modal modal-content modal-header fade gallery-size">  
 <button class="close" type="button" data-dismiss="modal" aria-hidden="true">&times;</button>
 <h4 class="modal-title">Select image</h4>
 <div class="image_wall2">
  <?php  while ($row = $statement->fetch()) { 
   echo '<div class="pos2"><img class="img_pos" src="../uploads/'.$row["file_name"] . '" /><label class="lab2">Choose Image 
<input type="radio" name="img_name"     class="radio_pos" value="'.$row["file_name"].'"/></label></div>';
    } ?>   
  </div>
</div> 