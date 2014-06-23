<?php require_once('authenticate.php'); 
error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', TRUE);
  
/* Db Details */
require_once('../includes/db_config.php');

/* Query SQL Server for inserting data. */
$tsql = "select category_id, category_name FROM 387732_phpbook1.category";
$stmt = mysql_query($tsql);
if(!$stmt)
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
<?php include '../includes/headereditor.php' ?>
<script type="text/Javascript">
function assigncontent()
{
  var sHTML = $('#summernote').code();
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

                <div id="summernote" class="summernote" style="background-color:white;"><?php if (isset($_REQUEST["content"])){ echo $_REQUEST["content"]; }?></div>

             </td> 
			      </tr>
            <tr><td>&nbsp;</td></tr>
            <tr>
              <td style="vertical-align:top;"><span class="fieldheading">Category:&nbsp;</span></td>
              <td>   <select id="CategoryId" name="CategoryId">
              
                 <?php while($row = mysql_fetch_array($stmt)) { ?>
                <option value="<?php  echo $row['category_id']; ?>"><?php  echo $row['category_name']; ?></option>
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
                <?php include '../includes/gallerymodal.php' ?> <?php if (isset($_REQUEST["imgname"])){ echo "<input type='text' id='fimage' name='fimage' value='".$_REQUEST["imgname"]."' readonly/>"; } if(isset($_REQUEST["pressed"])){ echo"<input type='hidden' id='fimagehidden' name='fimagehidden' value='".$_REQUEST["pressed"]."' />"; }?>
            
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
<?php include '../includes/footereditor.php' ?>
