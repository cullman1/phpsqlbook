

<?php include '../includes/header.php' ?>
 <form id="form1" method="post" action="../login/login-user.php?page=pages">
      <div class="col-md-4"><h1>Please login:</h1></div>
      <div class="col-md-4">
        <form role="form">
         <div class="form-group">
           <label for="emailAddress">Email address</label>
           <input type="email" class="form-control" id="emailAddress" name="emailAddress" placeholder="Enter email" style="width:200px;">
         </div>
         <div class="form-group">
           <label for="password">Password</label>
           <input type="password" class="form-control" id="password" name="password" placeholder="Password" style="width:200px;">
         </div>
         <button type="submit" class="btn btn-default">Login</button>
            <div class="form-group">
                <br />
         <a href="forgotten-password.php">Forgotten your Password?</a>
         </div>

          <div id="Status" ><?php 
    
    if(isset($_REQUEST['login']))
    {
    echo "<br/><span class='red'>Login failed</span>";
    }

    ?></div>
       </form>
      </div>

    </div> <!-- /container -->
   
</form>
<?php include '../includes/footer.php' ?>