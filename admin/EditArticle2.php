<?php 
require_once('authenticate.php'); 
  
/* Db Details */
require_once('../includes/db_config.php');

/* Query SQL Server for selecting article and associated media. */
$tsql = "SELECT title, content, article.article_id,  category_id, parent_id FROM 387732_phpbook1.article where article.article_id=".$_REQUEST['article_id'];
$stmt = mysql_query($tsql);
if(!$stmt) {   die("Select article failed: ". mysql_error()); }

/* Query SQL Server for selecting category. */
$tsql3 = "select category_id, category_name FROM 387732_phpbook1.category";
$stmt3 = mysql_query($tsql3);
if(!$stmt3) { die("Select category failed: ". mysql_error()); }

/* Query SQL Server for selecting parent. */
$tsql2 = "select parent_id, parent_name FROM 387732_phpbook1.parent";
$stmt2 = mysql_query($tsql2);
if(!$stmt2) {  die("Select parent failed: ". mysql_error()); }

/* Query SQL Server linking media to article via media link table. */
$tsql4 = "select * FROM 387732_phpbook1.media_link JOIN 387732_phpbook1.media ON media.media_id = media_link.media_id where article_id=".$_REQUEST['article_id'];
$stmt4 = mysql_query($tsql4);
if(!$stmt4) {  die("Select media failed: ". mysql_error()); }

include '../includes/headereditor2.php' ?>

<script type="text/Javascript">
function assigncontent()
{
  var textControl = document.getElementById("some-textarea");
  var sHTML = textControl.innerHTML;
  var sHTML2 = $('#ArticleTitle').val();
  $('#ArticleContent').val(sHTML);
  $('#ArticleTitle').val(sHTML2);
}
</script>

<div id="body">
  <form id="form1" method="post" action="editdata.php" onsubmit="assigncontent()" enctype="multipart/form-data">
    <?php while($row = mysql_fetch_array($stmt)) { ?>
      <div id="middlewide">
        <div id="leftcol">
          <h2>Edit an Article</h2><br />
            <table>
              <tr>
                <td><span class="fieldheading">Title:</span></td>
                <td><input id="ArticleTitle" name="ArticleTitle" type="text" value="<?php echo $row['title']; ?>"/></td> 
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td><span class="fieldheading">Content:</span></td>
                <td>
               
              <?php include '../includes/richtextcontrol.php' ?>

                </td> 
              </tr>
              <tr><td id='placehere'>&nbsp;</td></tr>
              <tr>
                <td>Featured Image:</td>
                <td>
                  <?php include '../includes/gallerymodaloriginal.php' ?> 
                  <?php if (isset($_REQUEST["imgname"]))
                        { 
                          echo "<input type='text' id='fimage' name='fimage' value='".$_REQUEST["imgname"]."' readonly/>"; 
                        } 
                        else if (isset($row['name']))
                        { 
                          echo "<input type='text' id='fimage' name='fimage' value='".$row['name']."' readonly/>"; 
                        } 
                        echo"<input type='hidden' id='fimagehidden' name='fimagehidden' value='"; 
                        if (isset($_REQUEST["pressed"]))
                        { 
                          echo $_REQUEST["pressed"];
                        } 
                        else if(isset($row['media_id']))
                        { 
                          echo $row['media_id'];
                        } 
                        echo "' />"; 
                  ?>
                </td>
              </tr>
<tr><td>&nbsp;</td></tr>
              <tr>
                <td>Associated Docs:</td>
                <td>

                <?php while($row4 = mysql_fetch_array($stmt4)) {
                  if (isset($row4['name']) && ($row4['file_type']!="image/jpeg" && $row4['file_type']!="image/png"))
                        { 
                          echo $row4['name'] ." - " . "<span name='deletebutton".$row4['media_id']."' class='glyphicon glyphicon-remove red deleter'></span></div><br/>"; 
                          echo "<input type='hidden' id='fdochidden". $row4['media_id']."' name='fdochidden". $row4['media_id']."' value='' />"; 
                        } 
                }
                  ?> 
                        <input type="file" id="document_upload" name="document_upload"> 
                </td>
              </tr>



    <tr><td>&nbsp;</td></tr>
            <tr>
              <td style="vertical-align:top;"><span class="fieldheading">Category:&nbsp;</span></td>
              <td>   <select id="CategoryId" name="CategoryId">
              
                 <?php while($row3 = mysql_fetch_array($stmt3)) { ?>
                <option value="<?php  echo $row3['category_id']; ?>"<?php if( $row3['category_id'] == $row['category_id']) { echo "selected";} ?> ><?php  echo $row3['category_name']; ?></option>
                  <?php } ?> 
                  </select>
             </td>


 <tr><td>&nbsp;</td></tr>
            <tr>
              <td style="vertical-align:top;"><span class="fieldheading">Parent Page:&nbsp;</span></td>
              <td>   <select id="PageId" name="PageId">
              
                 <?php while($row2 = mysql_fetch_array($stmt2)) { ?>
                <option value="<?php  echo $row2['parent_id']; ?>"  <?php if( $row2['parent_id'] == $row['parent_id']) { echo "selected";} ?>><?php  echo $row2['parent_name']; ?></option>
                  <?php } ?> 
                  </select>
             </td>

              <tr><td>&nbsp;</td></tr>
              <tr>
                <td></td>
                <td> <input id="SaveButton" type="submit" name="submit" Value="Submit"  /><input id="ArticleContent" name="ArticleContent" type="hidden" value=""/></td>  
              </tr> 
            </table>
            <br />
            <br />
            <div id="Status" >
              <?php 
                if(isset($_GET['submitted']))
                {
                  echo "<span class='red' style='color:red'>Article successfully edited</span>";
                }
              ?>
            </div>
          </div>
          <br />
          <a id="Return2" href="pages.php">Return to Main Page</a>
          <input id="article_id" name="article_id" type="hidden" value="<?php echo $_REQUEST['article_id'];?>"/>
        </div>
      <?php } ?>         
    </form><!--end content --> 
  </div>
<div class="clear"></div>
<script src="../js/deletebutton.js" type="text/javascript"></script>
<?php include '../includes/footereditor2.php' ?>