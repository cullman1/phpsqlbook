<?php   require_once('../classes/user.php') ?>

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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script type="text/javascript" src="http://tarruda.github.com/bootstrap-datetimepicker/assets/js/bootstrap-datetimepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" media="screen" href="http://tarruda.github.com/bootstrap-datetimepicker/assets/css/bootstrap-datetimepicker.min.css">
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <script src="../js/jquery.hotkeys.js"></script>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/admin.css" rel="stylesheet" />
    <script src="../js/bootstrap-wysiwyg.js"></script>
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
            <li><a href="../admin/index.php">Dashboard</a></li>
            <li><a href="../admin/pages.php">Pages</a></li>
            <li><a href="../admin/categories.php">Categories</a></li>
            <li><a href="../admin/media.php">Media</a></li>
            <li><a href="../admin/comments.php">Comments</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Users <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="../admin/admin.php">View admins</a></li>
                <li><a href="../admin/new-admin.php">Create admins</a></li>
                <li class="divider"></li>
                <li class="dropdown-header">Public</li>
                <li><a href="../admin/user.php">View users</a></li>
                <li><a href="../admin/new-user.php">Create users</a></li>
              </ul>
            </li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
           <ul class="nav navbar-nav navbar-right">
            <?php
            if (isset($_SESSION["user2"])) 
            { 
                $so = $_SESSION["user2"];
                $user_object = unserialize($so);
                $auth = $user_object->getAuthenticated();
                if(!empty($auth)) 
                { ?> 
                    <li><?php echo $user_object->getFullName(); ?>&nbsp;<a href="../login/logout.php">Logout</a></li>
          <?php } 
                else 
                { ?>
                    <li><a href="../login/logon.php?page=pages">Login</a></li>
          <?php }
           } 
           else 
           { ?>
                <li><a href="../login/logon.php?page=pages">Login</a></li>
     <?php } ?> 
          </ul>
          </ul>
        </div> <!--/.nav-collapse -->
      </div>
    </div>
    <div class="container">
        <br />