<?php require_once('authenticate.php'); 
error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', TRUE);
  
/* Db Details */
require_once('../includes/db_config.php');

/* Query SQL Server for inserting data. */
$tsql22 = "select category_id, category_name FROM 387732_phpbook1.category";
$stmt22 = mysql_query($tsql22);
if(!$stmt22)
{  
    /* Error Message */
    die("Query failed: ". mysql_error());
}

/* Query SQL Server for inserting data. */
$tsql2 = "select parent_id, parent_name FROM 387732_phpbook1.parent";
$stmt2 = mysql_query($tsql2);
if(!$stmt2)
{  
    /* Error Message */
    die("Query failed: ". mysql_error());
}

?>
<?php include '../includes/headereditor2.php' ?>
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
    <form id="galleryform" method="post" action="adddata.php" onsubmit="assigncontent()" enctype="multipart/form-data">
      <div id="middlewide">
        <div id="leftcol">
          <h2>Add an Article</h2><br />
             <div id="Status_Post">
            <?php 
             if(isset($_GET['submitted']))
             {
              echo "<span class='red' style='color:red;'>Article successfully created!</span>";
             }  
           ?>
         </div>
          <table>
            <tr>
				      <td><span class="fieldheading">Title:</span></td>
				      <td><input id="ArticleTitle" name="ArticleTitle" type="text" value="<?php if (isset($_REQUEST["title"])){ echo $_REQUEST["title"]; }?>" /></td> 
			       </tr>
              <tr><td>&nbsp;</td></tr>
            <tr>
				      <td style="vertical-align:top;"><span class="fieldheading">Content:&nbsp;</span></td>
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
    } ?>
    </div>

             </td> 
			      </tr>
            <tr><td>&nbsp;</td></tr>
            <tr>
              <td style="vertical-align:top;"><span class="fieldheading">Category:&nbsp;</span></td>
              <td>   <select id="CategoryId" name="CategoryId">
              
                 <?php 
                 while($row22 = mysql_fetch_array($stmt22)) { ?>
            
                <option value="<?php  echo $row22['category_id']; ?>"><?php  echo $row22['category_name']; ?></option>
                  <?php } ?> 
                  </select>
             </td>

             <tr><td>&nbsp;</td></tr>
            <tr>
              <td style="vertical-align:top;"><span class="fieldheading">Parent Page:&nbsp;</span></td>
              <td>   <select id="PageId" name="PageId">
              
                 <?php while($row2 = mysql_fetch_array($stmt2)) { ?>
                <option value="<?php  echo $row2['parent_id']; ?>"><?php  echo $row2['parent_name']; ?></option>
                  <?php } ?> 
                  </select>
             </td>


             <tr><td>&nbsp;</td></tr>
            <tr>

              <td>Featured Image:</td>
              <td>
                <?php include '../includes/gallerymodaloriginal.php' ?> <?php if (isset($_REQUEST["imgname"])){ echo "<input type='text' id='fimage' name='fimage' value='".$_REQUEST["imgname"]."' readonly/>"; } if(isset($_REQUEST["pressed"])){ echo"<input type='hidden' id='fimagehidden' name='fimagehidden' value='".$_REQUEST["pressed"]."' />"; }?>
            
              </td>
              
            </tr>
            <tr><td>&nbsp;</td></tr>
                 <tr>

              <td>Add associated documents/pdfs:</td>
              <td>
              
              <input type="file" id="document_upload" name="document_upload"> 
        
            
              </td>
              
            </tr>
            <tr><td>&nbsp;</td></tr>
            <tr>
				      <td></td>
        
				      <td><input id="SaveButton" type="submit" name="submit" Value="Submit"  /></td>
              <input id="ArticleContent" name="ArticleContent" type="hidden" />
           

			       </tr> 
          </table>
          <br />
          <br />
       
      </div>
      <br />
      <a id="Return2" href="../index.html">Return to Main Page</a>
      </div>
    </form>
  <!--end content --> 
  </div>
<div class="clear"></div>
<?php include '../includes/footereditor2.php' ?>
