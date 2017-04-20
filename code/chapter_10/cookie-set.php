<?php
$color = filter_input(INPUT_COOKIE, 'color');

if($_SERVER['REQUEST_METHOD'] == 'POST') {
  $color = filter_input(INPUT_POST, 'color');
    setcookie('color', $color, time() + (60 * 1), '/');
}
?>
 <link rel="stylesheet" href="css/styles.css" />
</head>
<body class="<?= $color?>">
<form method="post" action="cookie-set.php"> 
 Select color scheme:
  <select name="color" > 
    <option value="dark">dark</option>
    <option value="light">light</option>
  </select>
  <input type="submit" value="submit"/>
</form>