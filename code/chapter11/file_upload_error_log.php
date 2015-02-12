<?php 
/* Db Details */
require_once('../includes/db_config.php');

/* Add header */
include '../includes/header.php' ?>
<div id="body">
    <form id="galleryform" method="post" action="file_upload_error_log.php" onsubmit="assigncontent()" enctype="multipart/form-data">
      <div id="middlewide">
        <div id="leftcol">
          <h2>Upload an Image</h2><br />
          <div id="Status_Post">
               <?php 
               function log_error($file, $message, $code, $line) {
                   $serverName = "mysql51-036.wc1.dfw1.stabletransit.com";
                   $userName = "387732_phpbook1";
                   $password = "F8sk3j32j2fslsd0"; 
                   $databaseName = "387732_phpbook1";
                   $dbHost = new PDO("mysql:host=$serverName;
                        dbname=$databaseName", 
                                       $userName, 
                                       $password);
                   $dbHost->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
                   $insert_media_sql = "INSERT INTO error_log (file, message, code, line, date_raised) VALUES ('".$file."','". $message."','".$code."','". $line."', '". date("Y-m-d H:i:s") ."')";
                   $insert_media_result = $dbHost->prepare($insert_media_sql);
                   $insert_media_result->execute();
               }

               if(isset($_FILES['image_upload']))
               {
               
                   if($_FILES["image_upload"]["name"]!="")
                   {
                 
                       try
                       {
                         
                           $folder = "../uploads/".$_FILES["image_upload"]["name"];
                           
                           if (($_FILES["image_upload"]["type"] != "image/jpeg") && ($_FILES["image_upload"]["type"] != "image/png") && ($_FILES["image_upload"]["type"] != "image/gif")) 
                           {
                            
                               throw new Exception('Illegal file type');
                           }
                          

                           if (!move_uploaded_file($_FILES['image_upload']['tmp_name'], $folder))
                           {
                               throw new Exception('Unable to upload file');
                           }
                           
                       }
                       catch (Exception $ex)
                       {
                           log_error($ex->getFile(), $ex->getMessage(),$ex->getCode(),  $ex->getLine());              
                           unset($_REQUEST['Submitted']);
                           echo "<span class='red' style='color:red;'>".$ex->getMessage()."</span><br/>";
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
                       <input type="file" id="image_upload" name="image_upload" accept="image/jpeg, image/png, image/gif" /> 
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