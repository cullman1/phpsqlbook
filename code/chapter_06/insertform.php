<?php  include '../includes/header-register.php'; ?>
 <form id="form1" method="post" action="insertdata.php">
  <div class="wholeform">
    <div class="col-md-4"><h1>Please register:</h1></div>
      <div class="form-group">
        <label for="email">Email address</label>
        <input type="email" class="form-control" name="email" placeholder="Enter email">
       </div>
       <div class="form-group">
        <label for="firstName">First name</label>
        <input type="text" class="form-control" name="firstName" placeholder="First name">
       </div>
       <div class="form-group">
         <label for="lastName">Last name</label>
         <input type="text" class="form-control" name="lastName" placeholder="Last name">
        </div>
        <div class="form-group">
          <label for="pwd">Password</label>
          <input type="password" class="form-control" name="pwd" placeholder="Password">
         </div>      
        <button type="submit" class="btn btn-default">Register</button>
   </div>
</form>
<?php require_once('../includes/footer-site.php'); ?>