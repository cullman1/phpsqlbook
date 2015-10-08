<form method="post" action="/cms/login/login/1">
  <h1>Please login:</h1>
   <div class="form-group">
  <label for="emailAddress">Email address</label>
 <input type="email" name="emailAddress" placeholder="Email">
 <label for="password">Password</label>
<input type="password" name="password" placeholder="Password">
         </div>
<button type="submit" class="btn btn-default">Login</button>
  <div id="Status" ><?php  if($this->parameters[0]=="3") {
   echo "<br/<br/><span class='red'>Login failed</span>";
            }   ?></div>
</form>