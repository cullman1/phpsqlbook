<form id="form1"  method="post" action="{{user.user_id}}" enctype="multipart/form-data">
   <h2>Edit User Profile</h2>
   <div class="form-group">
    <label class="fieldheading">User Name:</label>
    <input id="UserName" name="UserName" type="text" value="{{user.full_name}}" /></div>
   <div class="form-group">
    <label class="fieldheading">User Email:</label>
    <input id="UserEmail" name="UserEmail" type="text" value="{{user.email}}" /></div>
   <div class="form-group">
    <label class="fieldheading">User Status:</label>
    <input id="UserStatus" name="UserStatus" type="text" value="{{user.user_status}}" /></div>
   <div class="form-group">
    <label class="fieldheading" >User Image:</label>
    <img src="../login/{{user.user_image}}" />
    <input id="UserImage"  name="UserImage" disabled type="text" value="{{user.user_image}}" />
    <input type="file" id="uploader" name="uploader" /></div>
   <input id="SaveButton" type="submit" name="submit" Value="Submit"  />
   <input id="userid" name="userid" type="hidden" value="{{user.user_id}}"/>
   <input id="role" name="role" type="hidden" value="{{user.role_id}}"/>
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