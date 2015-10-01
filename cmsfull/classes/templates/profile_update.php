<form id="form1" method="post" action="{{user.user_id}}" enctype="multipart/form-data">
 <h2>Edit User Profile</h2>
 <div class="form-group">
  <label>User Name:</label>
  <input name="Name" type="text" value="{{user.full_name}}" />
  <label>User Email:</label>
  <input name="Email" type="text" value="{{user.email}}" />
  <label>User Status:</label>
  <input name="Status" type="text" value="{{user.status}}" />
  <label>User Image:</label>
  <img src="/cmsfull/assets/{{user.image}}" />
  <label>File:</label>
  <input id="ImgName" name="Image" disabled type="text" value="{{user.image}}" />
  <label></label><input type="file" id="uploader" name="uploader" />
 </div>
 <input name="Id" type="hidden" value="{{user.user_id}}"/>
 <input id="Role" name="role" type="hidden" value="{{user.role_id}}"/>
 <div id="Status" class="form-group" >
  <input type="submit" value="Submit" /><br/><br/>
  <a href="/cmsfull/recipes">Return to Main Site</a>

   <?php
if ($_GET["query"]=="success") {
 echo "<span class='red'>Profile successfully edited</span>";
 } else if ($_GET["query"]=="fail") { 
echo "<span class='red'>Profile not updated</span>"; 
}?>
 </div>
 <script>
  $("#uploader").on('change', function() {
   var filename = $('#uploader').val();
   filename2 = filename.replace("fakepath","");
   filename2 = filename2.replace("C:\\\\","");
   $("#UserImage").val(filename2);
  });
 </script>
</form> 