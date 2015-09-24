 <form id="form1" method="post" action="<?php echo "http://".$_SERVER['HTTP_HOST']; ?>/cmsfull/login/login/1">
       <div class="wholeform">
      <div class="col-md-4"><h1>Please login: <?php if (isset($_SESSION['user2'])) {echo $_SESSION['user2']; }?></div>
      <div class="col-md-4">
         <div class="form-group">
           <label for="emailAddress">Email address</label>
           <input type="email" class="form-control" id="emailAddress" name="emailAddress" placeholder="Enter email">
         </div>
         <div class="form-group">
           <label for="password">Password</label>
           <input type="password" class="form-control" id="password" name="password" placeholder="Password">
         </div>
         <button type="submit" class="btn btn-default">Login</button>
         <br/>
         <br/>
          <div id="Status" ><?php  if($this->parameters[0]=="3") {
    echo "<br/<br/><span class='red'>Login failed</span>";
    }    ?></div>
  </div>
 </div>
</form>