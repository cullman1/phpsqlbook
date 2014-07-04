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
  var hello = document.getElementById("some-textarea");
  var sHTML = hello.innerHTML;
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
               
 <div class="btn-toolbar" data-role="editor-toolbar" data-target="#some-textarea">
      <div class="btn-group">
        <a class="btn dropdown-toggle" data-toggle="dropdown" title="Font Size"><i class="icon-text-height"></i>&nbsp;<b class="caret"></b></a>
          <ul class="dropdown-menu">
          <li><a data-edit="fontSize 5"><font size="5">Huge</font></a></li>
          <li><a data-edit="fontSize 3"><font size="3">Normal</font></a></li>
          <li><a data-edit="fontSize 1"><font size="1">Small</font></a></li>
          </ul>
      </div>
      <div class="btn-group">
        <a class="btn" data-edit="bold" title="Bold (Ctrl/Cmd+B)"><i class="icon-bold"></i></a>
        <a class="btn" data-edit="italic" title="Italic (Ctrl/Cmd+I)"><i class="icon-italic"></i></a>
        <a class="btn" data-edit="strikethrough" title="Strikethrough"><i class="icon-strikethrough"></i></a>
        <a class="btn" data-edit="underline" title="Underline (Ctrl/Cmd+U)"><i class="icon-underline"></i></a>
      </div>
      <div class="btn-group">
        <a class="btn" data-edit="insertunorderedlist" title="Bullet list"><i class="icon-list-ul"></i></a>
        <a class="btn" data-edit="insertorderedlist" title="Number list"><i class="icon-list-ol"></i></a>
        <a class="btn" data-edit="outdent" title="Reduce indent (Shift+Tab)"><i class="icon-indent-left"></i></a>
        <a class="btn" data-edit="indent" title="Indent (Tab)"><i class="icon-indent-right"></i></a>
      </div>
      <div class="btn-group">
        <a class="btn" data-edit="justifyleft" title="Align Left (Ctrl/Cmd+L)"><i class="icon-align-left"></i></a>
        <a class="btn" data-edit="justifycenter" title="Center (Ctrl/Cmd+E)"><i class="icon-align-center"></i></a>
        <a class="btn" data-edit="justifyright" title="Align Right (Ctrl/Cmd+R)"><i class="icon-align-right"></i></a>
        <a class="btn" data-edit="justifyfull" title="Justify (Ctrl/Cmd+J)"><i class="icon-align-justify"></i></a>
      </div>
      <div class="btn-group">
      <a class="btn dropdown-toggle" data-toggle="dropdown" title="Hyperlink"><i class="icon-link"></i></a>
        <div class="dropdown-menu input-append">
          <input class="span2" placeholder="URL" type="text" data-edit="createLink"/>
          <button class="btn" type="button">Add</button>
        </div>
        <a class="btn" data-edit="unlink" title="Remove Hyperlink"><i class="icon-cut"></i></a>

      </div>
      
      <div class="btn-group">
           <?php include '../includes/gallerymodal2.php' ?> 
      </div>
      <div class="btn-group">
        <a class="btn" data-edit="undo" title="Undo (Ctrl/Cmd+Z)"><i class="icon-undo"></i></a>
        <a class="btn" data-edit="redo" title="Redo (Ctrl/Cmd+Y)"><i class="icon-repeat"></i></a>
      </div>
    </div>

    <div id="some-textarea">
    <?php if (isset($_REQUEST["content"]))
    {
      if (!is_null($_REQUEST["content"]))
        { 
          echo $_REQUEST["content"]; 
      } 
    } else { echo $row['content']; }?>
    </div>           
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