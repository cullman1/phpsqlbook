<?php require_once('../includes/db_config.php');
      $num_rows = 0;
      $form_error = array('email' => '');
      if($_SERVER['REQUEST_METHOD'] == 'POST') {
         if (!empty($_POST['email'])) {
            $num_rows = get_existing_user($dbHost, $_POST["email"]);   
            if ($num_rows>0) {
                $form_error['email'] = "Email address exists";
            } else {
                $form_error['email'] = "Email address doesn't exist";
            } 
         } else {
             $form_error['email'] = "Email field must contain a value";   
         }
      } 

      function get_existing_user($dbHost, $email) {
          $query = "SELECT * from user WHERE email = :email";
          $statement = $dbHost->prepare($query);
          $statement->bindParam(":email",$email);
          $statement->execute();
          $rows = $statement->fetchAll();
          return count($rows);
      }
      include '../includes/header-register.php'; ?>
<form id="register" name="register" method="post" action="email-check.php">
      <h1>Check to see if email exists</h1>
      <div class="form-group">
         <label for="email">Email address</label>
         <input type="email" name="email" placeholder="Enter email"><?=$form_error['email']; ?>
      </div>
      <input type="submit" class="button_block btn btn-default" value="Submit">
</form>
<?php include '../includes/footer-site.php'; ?>
