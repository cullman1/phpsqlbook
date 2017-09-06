<form method="post" action="register.php">
  <label>First name <input type="text" name="forename" value="<?=$forename ?>" />
  </label> <span class="error"><?= $error['forename'] ?></span><br />
  <label>Last name <input type="text" name="surname" value="<?=$surname ?>" />
  </label> <span class="error"><?= $error['surname'] ?></span><br />
  <label>Email address <input type="email" name="email" value="<?=$email ?>" />
  </label> <span class="error"><?= $error['email'] ?></span><br />
  <label>Password <input type="password" name="password" />
  </label> <span class="error"><?= $error['password'] ?></span><br />
  <label>Confirm Password <input type="password" name="confirm" />
  </label> <span class="error"><?= $error['confirm'] ?></span><br />
   <button type="submit">Register</button>
</form>