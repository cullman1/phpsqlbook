
<form method="post" action="/phpsqlbook/logincheck/">
  <h1>Please login:</h1>
  <div class="form-group">
   <label for="emailAddress">Email address</label>
 <input type="email" name="emailAddress" placeholder="Email"><br/><br/>
   <label for="password">Password</label>
   <input type="password" name="password"  
    placeholder="Password">
  </div><br/>
<button type="submit" class="btn btn-default">Login</button>
  <div id="Status" ><?php if(isset($this->item)) {
   echo "<br/<br/><span class='red'>Login failed</span>";
            }   ?></div>
</form>
