<?php 
require_once('authenticate.php'); 
error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', TRUE);
  
/* Db Details */
require_once('../includes/db_config.php');

if (isset($_REQUEST["publish"]))
{
/* Query */
$tsql = "update article set date_published = null WHERE article_id=".$_REQUEST["articleid"];
$stmt = mysql_query($tsql);
if(!$stmt)
{  
    /* Error Message */
    die("Query failed: ". mysql_error());
}
else
{
    /* Redirect to original page */
    header('Location:../admin/pages.php');
}
  } 
else {
include ('../includes/header.php');  ?>
<div id="publishcontainer">
        <script type="text/Javascript">
function assigncontent()
{
  var sHTML = $('#datetimepick').val();  
  $('#articlecontent').val(sHTML);
}
</script>
<h2>Publish article</h2>
 <form method="post" action="publisharticle.php" onsubmit="assigncontent()">

<label for="today">Immediately</label>
<input type="checkbox" id="immediatepublish" name="immediatepublish" onchange="if ( $('#dtb').css('visibility') == 'hidden' ) $('#dtb').css('visibility','visible'); else $('#dtb').css('visibility','hidden');"/>
<div id="dtb">
<div>or</div>
<div>Future Date</div>
<div id="datetimepicker" class="input-append date">
      <input id="datetimepick" name="datetimepick" type="text" />
      <span class="add-on">
        <i data-time-icon="icon-time" data-date-icon="icon-calendar"></i>
      </span>
    </div>
   <script type="text/javascript">
      $('#datetimepicker').datetimepicker({
        format: 'yyyy/MM/dd hh:mm:ss',
        language: 'en-US'
      });
    </script>
  </div>
<br/>
 <input id="SaveButton" type="submit" name="submit" Value="Publish Article"  />
<input id="articleid" name="articleid" type="hidden" value="<?php echo $_REQUEST["articleid"]?>"/>
<input id="articlecontent" name="articlecontent" type="hidden" value=""/>
     <input id="Submitted" name="Submitted" type="hidden" value="true"/>
      </div> <!-- /container -->
</form>
</div>
<?php }  ?>
<?php include '../includes/footer.php' ?>