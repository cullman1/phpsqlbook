<div id="body">
    <form id="form1" name="form1" method="post" action="profile.php" enctype="multipart/form-data">
       <?php while($select_user_row = $select_user_result->fetch()) { ?>
      <div id="middlewide">
        <div id="leftcol">
          <h2>Edit User Profile</h2><br />
          <table>
            <tr>
				 <td><span class="fieldheading">User Name:</span></td>
				 <td><input id="UserName" name="UserName" type="text" value="<?php echo $select_user_row['user.full_name']; ?>" /></td> 
			</tr>
            <tr><td></td><td>&nbsp; </td></tr>
            <tr>
				 <td><span class="fieldheading">User Email:</span></td>
				 <td><input id="UserEmail" name="UserEmail" type="text" value="<?php echo $select_user_row['user.email']; ?>" /></td> 
			</tr>
                    <tr><td> </td><td>&nbsp; </td></tr>
              <tr>
				 <td><span class="fieldheading">User Status:</span></td>
				 <td><input id="UserStatus" name="UserStatus" type="text" value="<?php echo $select_user_row['user.user_status']; ?>" /></td> 
			</tr>
        
            <tr><td></td><td>&nbsp; </td></tr>
               <tr>
				 <td style="vertical-align:top;"><span class="fieldheading" >User Image:</span></td>
                   	 <td><img src="../login/<?php echo $select_user_row['user.user_image']; ?>" /><br /><br /><input id="UserImage"  name="UserImage" disabled type="text" value="<?php echo $select_user_row['user.user_image']; ?>" /><br /><br /><input type="file" id="uploader" name="uploader" /></td> 
               
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
	           if(isset($_REQUEST['submitted']))  {
		          echo "<span class='red'>Profile successfully edited</span>";
	           }  
	         ?>
         </div>
            <script>
$("#uploader").on('change', function() {
   var filename = $('#uploader').val();
filename2 = filename.replace("fakepath","");
filename2 = filename2.replace("C:\\\\","");
        $("#UserImage").val(filename2);
});
            </script>
      </div>
      <br />
      <a id="Return2" href="../../article">Return to Main Site</a>
      </div>
    </form>    <?php } ?>
</div>
<div class="clear"></div>