<?php 
require_once('authenticate.php'); 
  
/* Db Details */
require_once('../includes/db_config.php');

/* Query SQL Server for selecting category template. */
$select_user_sql = "select * FROM user where user_id=".$_REQUEST["userid"];
$select_user_result = $dbHost->prepare($select_user_sql);
$select_user_result->execute();
$select_user_result->setFetchMode(PDO::FETCH_ASSOC);
include '../includes/header.php' ?>
  <div id="body">
    <form id="form1" name="form1" method="post" action="submit-user.php" enctype="multipart/form-data">
       <?php while($select_user_row = $select_user_result->fetch()) { ?>
      <div id="middlewide">
        <div id="leftcol">
          <h2>Edit User</h2><br />
          <table>
            <tr>
				 <td><span class="fieldheading">User Name:</span></td>
				 <td><input id="UserName" name="UserName" type="text" value="<?php echo $select_user_row['full_name']; ?>" /></td> 
			</tr>
            <tr><td></td><td>&nbsp; </td></tr>
               <tr>
				 <td><span class="fieldheading">User Email:</span></td>
				 <td><input id="UserEmail" name="UserEmail" type="text" value="<?php echo $select_user_row['email']; ?>" /></td> 
			</tr>
              <tr><td> </td><td>&nbsp; </td></tr>
            <tr><td></td><td>&nbsp; </td></tr>
               <tr>
				 <td style="vertical-align:top;"><span class="fieldheading" >User Image:</span></td>
                   	 <td><input id="UserImage" name="UserImage" type="text" value="<?php echo $select_user_row['user_image']; ?>" /><br /><br /><input type="file" id="uploader" name="uploader" /></td> 
               
			</tr>
              <tr><td> </td><td>&nbsp; </td></tr>
            <tr>
		        <td></td>
				<td><input id="SaveButton" type="submit" name="submit" Value="Submit"  /></td>
			</tr> 
          </table>
          <input id="userid" name="userid" type="hidden" value="<?php echo $_REQUEST['userid']; ?>"/>
                   <input id="role" name="role" type="hidden" value="<?php echo $_REQUEST['role']; ?>"/>
          <br />
          <br />
          <div id="Status" >
            <?php 
	           if(isset($_REQUEST['submitted']))
	           {
		          echo "<span class='red'>User successfully edited</span>";
	           }  
	         ?>
         </div>
      </div>
      <br />
      <a id="Return2" href="../admin/user.php">Return to Main Page</a>
      </div>
    </form>
    <?php } ?>
  <!--end content --> 
</div>
<div class="clear"></div>
<?php include '../includes/footer-editor.php' ?>