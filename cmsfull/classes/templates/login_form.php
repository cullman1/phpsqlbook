<form id="form1" method="post" action="<?php echo "http://".$_SERVER['HTTP_HOST']; ?>/cmsfull/login/login/1">
    <h1>Please login: </h1>
         <div class="form-group">
           <label for="emailAddress">Email address</label>
           <input type="email" class="form-control" name="emailAddress" placeholder="Enter email">
           <label for="password">Password</label>
           <input type="password" class="form-control" name="password" placeholder="Password">
         </div>
         <button type="submit" class="btn btn-default">Login</button>
         <div id="Status" ><?php  if($this->parameters[0]=="3") {
            echo "<br/<br/><span class='red'>Login failed</span>";
            }   ?></div>
</form>