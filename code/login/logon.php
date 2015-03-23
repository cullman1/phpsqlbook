<form id="form1" method="post" action="login-user.php">
    <div class="wholeform">
        <br/>
        <div class="col-md-4"><h1>Please login:</h1></div>
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
            <div id="Status" ><?php 
                if(isset($_REQUEST['login'])) {
                    echo "<br/><span class='red'>Login failed</span>";
                } ?></div>
            </div>
      </div>
</form>
