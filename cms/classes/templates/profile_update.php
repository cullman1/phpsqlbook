<form method="post" action="{{user.user_id}}" enctype="multipart/form-data">
 <h2>Edit User Profile</h2>
 <div class="form-group">
  <label>User Name:</label>
  <input name="Name" type="text" value="{{user.full_name}}"/>
  <label>User Email:</label>
  <input name="Email" type="text" value="{{user.email}}"/>
  <label>User Status:</label>
  <input name="Status" type="text" value="{{user.status}}"/>
  <label>User Image:</label>
  <img src="/cms/assets/{{user.image}}" />
  <label>File:</label>
  <input name="Image" disabled type="text" 
   value="{{user.image}}" />
  <label></label><input type="file" id="File" name="File" />
 </div>
 <input name="Id" type="hidden" value="{{user.user_id}}"/>
 <input name="Role" type="hidden" value="{{user.role_id}}"/>
 <div id="Status" class="form-group" >
 <?php if ($_GET["query"]=="success") {
 echo "<span class='red'>Profile successfully edited</span>";
 } else if ($_GET["query"]=="fail") { 
echo "<span class='red'>Profile not updated</span>";
  }  ?>
  <input type="submit" value="Submit" /><br/><br/>
  <a href="/cms/recipes">Return to Main Site</a>
 </div>
 <script>
  $("#uploader").on('change', function() {
   var filename = $('#uploader').val();
   filename2 = filename.replace("fakepath","");
   filename2 = filename2.replace("C:\\\\","");
   $("#UserImage").val(filename2); });
 </script>
</form> 