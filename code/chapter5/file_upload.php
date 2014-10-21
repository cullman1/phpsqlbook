<?php 
/* Db Details */
require_once('../includes/db_config.php');

/* Add header */
include '../includes/header.php' ?>
<div id="body">
    <form id="galleryform" method="post" action="file_upload.php" onsubmit="assigncontent()" enctype="multipart/form-data">
      <div id="middlewide">
        <div id="leftcol">
          <h2>Upload an Image</h2><br />
          <div id="Status_Post">
               <?php 
               if(isset($_FILES['image_upload']))
               {
                   if($_FILES["image_upload"]["name"]!="")
                   {
                    
                       try
                       {
                           $folder = "../uploads/".$_FILES["image_upload"]["name"];
                           if (!move_uploaded_file($_FILES['image_upload']['tmp_name'], $folder))
                           {
                               throw new Exception('Unable to move file');
                           }
                       }
                       catch (Exception $ex)
                       {
                           unset($_REQUEST['Submitted']);
   
                       }
         
                   }
               }
               
               if(isset($_REQUEST['Submitted']))
               {
                   echo "<span class='red' style='color:red;'>Image successfully uploaded!</span><br/>";
               }  
               ?>
          </div>
            <br/>
          <table>       
            <tr>
                <td>Upload image:</td>
                <td>
                    <input type="file" id="image_upload" name="image_upload"> 
                </td>
            </tr>
     
            <tr><td>&nbsp;</td></tr>    
            <tr>
				<td></td>
				<td>
                    <input id="SaveButton" type="submit" name="submit" Value="Submit" class="btn btn-primary" />
				</td>
                
			 </tr> 
          </table>
              <input id="Submitted" name="Submitted" type="hidden" value="true"/>
          <br />
          <br />  
      </div>
      </div>
    </form>
  <!--end content --> 
  </div>
<div class="clear"></div>
<?php include '../includes/footer-editor.php' ?>