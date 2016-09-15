<a data-toggle="modal" href="#image" class="btn"> <i class="icon-picture"></i></a>
<?php $sel_media_set = $dbHost->prepare("select * FROM media where file_type='image/jpeg' OR file_type='image/png'");
$sel_media_set->execute(); ?>
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
  <button type="button" data-dismiss="modal" class="close" aria-hidden="true">&times;</button>
  <h4 class="modal-title">Select image</h4>
  <div class="image_wall2">
    <?php  while ($sel_media_row = $sel_media_set->fetch()) { 
     echo '<div class="pos2"><img class="img_pos" src="../uploads/'. $sel_media_row["file_name"]. '" /><label class="lab2">Choose Image<input type="radio" name="img_name" class="radio_pos" value="'.$sel_media_row["file_name"].'"/></label></div>';
    } ?>   
  </div>
</div>    
                                                              


