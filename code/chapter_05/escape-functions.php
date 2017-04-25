<!DOCTYPE html>
<html>
<head>
  <title>Built-in functions, objects and arrays</title>
  <link rel="stylesheet" href="css/styles.css" />
</head>
<body>
<?php
  $allowed_tags        = 'You can only use <p> and <br> tags in your content.';
  $password_characters = 'Do not use these characters in your password: < > / & " \'.';
?>

<label for="bio">Bio</label>
  <p class="hint"><?php echo htmlspecialchars($allowed_tags); ?></p>
<textarea id="bio"></textarea>

<br>

<label for="password">Password</label>
  <p class="hint"><?php echo htmlentities($password_characters, ENT_QUOTES); ?></p>
<input type="password" id="password">
</body>
</html>