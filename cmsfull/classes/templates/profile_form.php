<form id="form1"  method="post" action="profile/set/1" enctype="multipart/form-data">
   <h2>Edit User Profile</h2>
   <div class="form-group">
    <label class="fieldheading">User Name:</label>
    <input id="UserName" name="UserName" type="text" value="{{user.full_name}}" /></div>
   <div class="form-group">
    <label class="fieldheading">User Email:</label>
    <input id="UserEmail" name="UserEmail" type="text" value="{{user.email}}" /></div>
   <div class="form-group">
    <label class="fieldheading">User Status:</label>
    <input id="UserStatus" name="UserStatus" type="text" value="{{user.status}}" /></div>
   <div class="form-group">
    <label class="fieldheading" >User Image:</label>
    <img src="../login/{{user.user_image}}" />
    <input id="UserImage"  name="UserImage" disabled type="text" value="{{user_image}}" />
    <input type="file" id="uploader" name="uploader" /></div>
   <input id="SaveButton" type="submit" name="submit" Value="Submit"  />
   <input id="userid" name="userid" type="hidden" value="<?php echo $_POST['userid']; ?>"/>
   <input id="role" name="role" type="hidden" value="<?php echo $_POST['role']; ?>"/>
   <div id="Status" >
     <?php if(isset($_POST['submitted']))  {
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
    <a id="Return2" href="../../recipes">Return to Main Site</a>
  </div>
</form> 