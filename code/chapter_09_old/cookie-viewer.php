<?php
$name  = filter_input(INPUT_COOKIE, 'name');
$color = filter_input(INPUT_COOKIE, 'color');
$color = $color ? $color : 'dark';
?>...
 <link rel="stylesheet" href="css/styles.css" />
</head>
<body class="<?= $color?>">
 <?php if ($name==null) { ?>
  <a href="cookie-set.php">Preferences</a> 
 <?php } else { ?>
  <a href="cookie-set.php"><?php echo $name; ?></a> 
 <?php }  ?>
 <div>Welcome to the home page</div>