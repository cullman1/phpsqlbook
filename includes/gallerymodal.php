<?php /* Query SQL Server for inserting data. */
$tsql = "select media.media_id, media_title, file_type, url, thumbnail, name, date_uploaded FROM 387732_phpbook1.media where file_type='image/jpeg' OR file_type='image/png'";
$stmt = mysql_query($tsql);
if(!$stmt)
{  
    /* Error Message */
    die("Query failed: ". mysql_error());
} ?>

<script type="text/javascript">
$(document).ready(function(){
    $(".btn-clicked").click(function(){
      
        $("#image").modal('hide');

        var sHTML = $('#summernote').code();
        var sHTML2 = $('#ArticleTitle').val();
        var _href = $(this).attr("data-url");
        $(this).attr("data-url", _href + '&title=' + sHTML2 + "&ArticleContent=" + sHTML);
        window.location.href = $(this).attr("data-url");
});
    });
</script>
<div id="image" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Select feature image</h4>
      </div>
      <div class="modal-body">
        <p>
          <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">

            <!-- Indicators -->
            <ol class="carousel-indicators" style="position: relative; top: 400px;">
              <?php 
                $loopCounter = 0;     
                $totalRecords = mysql_num_rows($stmt);
                for ($i=$loopCounter; $i<$totalRecords; $i++)
                { ?>
                  <li data-target="#carousel-example-generic" data-slide-to="<?php echo $loopCounter?>" <?php if($i==0){echo "class='active'";} ?> ></li>
        <?php   } ?>
            </ol>

            <!-- Wrapper for slides -->
            <div class="carousel-inner">
              <?php
                $innerCounter = 1;
                while($rowT = mysql_fetch_array($stmt))
                { ?>
                  <div class="item <?php if($innerCounter==1){echo "active";} ?>">
                    <img src='<?php echo $rowT["url"]; ?>' alt='<?php echo $rowT["media_title"]; ?>' />
                    <div class="carousel-caption" style="color:black; bottom: 60px;">
                      <?php echo $rowT["media_title"]; ?>
                    </div>
                    <br/>
                    <br/>
                    <div class="modal-footer" style="text-align:center;">
                      <button id="button<?php echo $rowT["media_id"]?>" type="button" data-url="<?php echo basename($_SERVER['PHP_SELF']);?>?pressed=<?php echo $rowT["media_id"]?><?php if(isset($_REQUEST["article_id"])){echo "&article_id=".$_REQUEST["article_id"];} ?>&imgname=<?php echo $rowT["name"]?>" class="btn-clicked btn btn-primary">Choose this image</a>
                      <!--  -->
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
              <span class="glyphicon glyphicon-chevron-right"></span>
            </a>
          </div>
        </p>
      </div>      
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal --> 
<a data-toggle="modal" href="#image" class="btn btn-primary btn-large">Add Featured Image</a></div>