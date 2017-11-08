<?php  include '../includes/header-register.php'; ?>
 <form id="form1" class="indent" method="post" action="insertdata.php">
    <div class="col-md-4"><h1>Please register:</h1>   
        <label for="email">Email address</label>
        <input type="email" class="form-control" name="email" placeholder="Enter email">
        <label for="firstName">First name</label>
        <input type="text" class="form-control" name="firstName" placeholder="First name">
        <label for="lastName">Last name</label>
        <input type="text" class="form-control" name="lastName" placeholder="Last name">
        <label for="pwd">Password</label>
        <input type="password" class="form-control" name="pwd" placeholder="Password">
        <button type="submit" class="btn btn-default">Register</button>
     </div>
</form>
<?php require_once('../includes/footer-site.php'); ?>