<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../../assets/ico/favicon.ico">
    <title>Simple CMS</title>
    <!-- include libries(jQuery, bootstrap, fontawesome) -->
    <script src="//code.jquery.com/jquery-1.9.1.min.js"></script>
    <link href="http://netdna.bootstrapcdn.com/font-awesome/3.0.2/css/font-awesome.css" rel="stylesheet">
    <script src="../js/jquery.hotkeys.js"></script>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.1/js/bootstrap.min.js"></script> 
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/admin.css" rel="stylesheet">
    <link href="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/css/bootstrap-combined.no-icons.min.css" rel="stylesheet">
    <script src="../js/bootstrap-wysiwyg.js"></script>
    <style>
      body {
        min-height: 2000px;
        padding-top: 70px;
      }
    </style>
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <!-- Fixed navbar -->
    <div class="navbar navbar-default navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php">Simple CMS</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li><a href="index.php">Dashboard</a></li>
            <li><a href="pages.php">Pages</a></li>
            <li><a href="categories.php">Categories</a></li>
            <li><a href="media.php">Media</a></li>
            <li><a href="comments.php">Comments</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Users <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="admin.php">View admins</a></li>
                <li><a href="new-admin.php">Create admins</a></li>
                <li class="divider"></li>
                <li class="dropdown-header">Public</li>
                <li><a href="user.php">View users</a></li>
                <li><a href="new-user.php">Create users</a></li>
              </ul>
            </li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <?php
           
            if (isset($_SESSION['authenticated'])) { ?> 
            <li>Hello <?php echo $_SESSION['username']; ?>&nbsp;<a href="logout.php">Logout</a></li>
 <?php } else { ?>
    <li><a href="logon.php?page=mainsite">Login</a></li>
    <?php } ?> 
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>

    <div class="container">