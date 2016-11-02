<form method="post" action="/phpsqlbook/profile/update?id={{user.id}}" enctype="multipart/form-data">
 <h2>Edit User Profile</h2>
 <div class="form-group">
  <label>User Forename:
  <input name="Forename" type="text" value="{{user.forename}}" /></label><br /><br />
     <label>User Surname:
  <input name="Surname" type="text" value="{{user.surname}}" /></label><br /><br />
  <label>User Email:
  <input name="Email" type="text" value="{{user.email}}" /></label><br /><br />
  <label>User Image:
  <img src="/phpsqlbook/uploads/{{user.image}}" /></label><br /><br />
  <label>File:
  <input id="image" name="image" disabled type="text" value="{{user.image}}" /></label><br /><br />
  <label><input name="img" type="file"/></label><br /><br />
 </div>
 <input name="Id" type="hidden" value="{{user.id}}"/>
 <input id="Role" name="role" type="hidden" value="{{user.role_id}}"/>
 <div id="Status" class="form-group" >
  <input type="submit" name="submit" value="Submit" /><br/><br/>
  <a href="/phpsqlbook/home">Return to Main Site</a>
     </form> 
 <div id="Div1" style="color:red;" ><br/><?php if(isset($message)) {
   echo $message;
            }   ?></div>
 <script>
  $("#uploader").on('change', function() {
   var filename = $('#uploader').val();
   filename2 = filename.replace("fakepath","");
   filename2 = filename2.replace("C:\\\\","");
   $("#UserImage").val(filename2);
  });
 </script>
