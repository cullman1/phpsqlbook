 <form id="form1" method="post" action="<?php echo "http://".$_SERVER['HTTP_HOST']; ?>/phpsqlbook/register/add">
      <h1>Please register:</h1>
           <label for="emailAddress">Email address
           <input type="email" class="form-control" id="emailAddress" name="emailAddress" placeholder="Enter email">
         </label><br/><br/>
         <div class="form-group">
           <label for="firstName">First name
           <input type="text" class="form-control" id="firstName" name="firstName" placeholder="First name"></label>
         <br/><br/>
           <label for="lastName">Last name
           <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Last name"></label>
       <br/><br/>
           <label for="password">Password
           <input type="password" class="form-control" id="password" name="password" placeholder="Password">
</label>
<br/><br/>

        <input id="Role" name="Role" type="hidden" value="2">
              
         <button type="submit" class="btn btn-default">Register</button>
         <br/>  <br/>
          <div id="Status" style="color:red;" ><br/><?php if(isset($this->message)) {
   echo $this->message;
            }   ?></div>
         </div>


</form>
