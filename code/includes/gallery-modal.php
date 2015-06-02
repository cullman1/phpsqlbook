<?php 
$select_mediaimages_sql = "select media.media_id, media_title, file_type, file_path, thumbnail, name, date_uploaded FROM media where file_type='image/jpeg' OR file_type='image/png'";
$select_mediaimages_result = $dbHost->prepare($select_mediaimages_sql);
$select_mediaimages_result->execute();
$select_mediaimages_result->setFetchMode(PDO::FETCH_ASSOC);
$totalRecords = $select_mediaimages_result->rowCount(); ?>
<script type="text/javascript">
    $(document).ready(function () {
        $(".btn-clicked").click(function () {
            $("#image").modal('hide');
            var sHTML = $('#some-text-area').code();
            var sHTML2 = $('#ArticleTitle').val();
            var _href = $(this).attr("data-url");
            $(this).attr("data-url", _href + '&ArticleTitle=' + sHTML2 + "&ArticleContent=" + sHTML);
            window.location.href = $(this).attr("data-url");
        });
    });
</script>


<div id="image" class="modal modal-content modal-header fade gallery-size">  
  <div>
   <div>
    <div>
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true"> 
&times;</button>
      <h4 class="modal-title">Select feature image</h4>
    </div>
    <div>
      <p>
        <div id="carousel-media" class="carousel slide" data-ride="carousel">
          <!-- Indicators -->
           <ol class="carousel-indicators carousel-pos">
             <?php 
             $loopCounter = 0;                
             for ($i=$loopCounter; $i<$totalRecords; $i++) { ?>
               <li data-target="#carousel-media" data-slide-to="<?php echo $loopCounter?>" <?php if($i==0){echo "class='active'";} ?> ></li>
           <?php   } ?>
          </ol>
          <!-- Wrapper for slides -->
          <div class="carousel-inner">
          <?php               
          $innerCounter = 1;
          while($select_mediaimages_row2 = $select_mediaimages_result->fetch()) { ?>
              <div class="item <?php if($innerCounter==1){echo "active";} ?>">
              <img src='<?php echo $select_mediaimages_row2["file_path"]; ?>' alt='<?php echo $select_mediaimages_row2["media_title"]; ?>' style="max-height: 500px;" />
              <div class="carousel-caption caption-text">
                 <?php echo $select_mediaimages_row2["media_title"]; ?>
              </div>
              <div class=”button-pos”>
              <button id='button<?php echo $select_mediaimages_row2["media_id"]?>' type="button" data-url="<?php echo basename($_SERVER['PHP_SELF']);?>?pressed=<?php echo $select_mediaimages_row2["media_id"]?><?php if(isset($_REQUEST["article_id"])){echo "&article_id=".$_REQUEST["article_id"];} ?>&imgname=<?php echo $select_mediaimages_row2["name"]?>" class="btn-clicked btn btn-primary">Choose this image</a>
               </div>
             </div>
             <?php $innerCounter= $innerCounter+1;
          } ?>
            </div>
          <!-- Controls -->
          <a class="left carousel-control" href="#carousel-media" data-slide="prev">
           <span class="glyphicon glyphicon-chevron-left"></span>
          </a>
          <a class="right carousel-control" href="#carousel-media" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right" style="right:0;"></span>
          </a>
        </div>
      </p>
    </div>      
  </div><!-- /.modal-content -->
 </div><!-- /.modal-dialog -->                                                </div><!-- /.modal -->                                                               <a data-toggle="modal" href="#image" class="btn btn-primary btn-large">Add Featured
Image </a>

