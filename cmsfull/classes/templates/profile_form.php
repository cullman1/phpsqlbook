<div id="body">
    <form id="form1" name="form1" method="post" action="profile.php" enctype="multipart/form-data">
        <div id="leftcol">
          <h2>Edit User Profile</h2>
         <label class="fieldheading">User Name:</label>
<input id="UserName" name="UserName" type="text" value="{{user.full_name}}" />
			<label class="fieldheading">User Email:</label>
				 <input id="UserEmail" name="UserEmail" type="text" value="{{user.email}}" />
				 <label class="fieldheading">User Status:</label>
				 <input id="UserStatus" name="UserStatus" type="text" value="{{user.status}}" /><	
				<label class="fieldheading" >User Image:</label>
                   	 <img src="../login/{{user.user_image}}" /><br /><br /><input id="UserImage"  name="UserImage" disabled type="text" value="{{user_image}}" /><br /><br /><input type="file" id="uploader" name="uploader" />
			<input id="SaveButton" type="submit" name="submit" Value="Submit"  />
          <input id="userid" name="userid" type="hidden" value="<?php echo $_REQUEST['userid']; ?>"/>
                   <input id="role" name="role" type="hidden" value="<?php echo $_REQUEST['role']; ?>"/>
          <br />
          <br />
          <div id="Status" >
            <?php if(isset($_REQUEST['submitted']))  {
		          echo "<span class='red'>Profile successfully edited</span>";
	           }  ?>
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
      <a id="Return2" href="../../recipes">Return to Main Site</a>
      </div>
    </form>   
<div class="clear"></div>