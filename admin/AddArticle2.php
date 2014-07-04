<?php 
/* Login check */
require_once('authenticate.php'); 

/* Db Details */
require_once('../includes/db_config.php');

/* Query SQL Server for selecting category. */
$tsql22 = "select category_id, category_name FROM 387732_phpbook1.category";
$stmt22 = mysql_query($tsql22);
if(!$stmt22){  die("Select Category failed: ". mysql_error()); }

/* Query SQL Server for selecting parent page. */
$tsql2 = "select parent_id, parent_name FROM 387732_phpbook1.parent";
$stmt2 = mysql_query($tsql2);
if(!$stmt2) {   die("Select Parent failed: ". mysql_error()); }

/* Add header */
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
                     
                          <?php include '../includes/richtextcontrol.php' ?>

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
