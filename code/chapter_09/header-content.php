<!DOCTYPE html>
<html lang="en">                                                                          <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Seeds Web Site Example">
    <meta name="author" content="Deciphered Ltd">
    <link rel="shortcut icon" href="../../assets/ico/favicon.ico">              
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>    
    <link href="../css/bootstrap-combined.no-icons.min.css" rel="stylesheet">
    <link href="../css/pagination.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
   <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
   <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>    
<body>
  <!-- Fixed navbar -->
  <div class="container containerback">
    <div style="z-index: 100;">
      <ul class="nav navbar-nav navbar-right floatright">
        <?php
        if (isset($_SESSION["username"]))
        {       ?>
           <li>Hello <?php echo $user_object->getFullName(); ?>&nbsp;
               <a href="../login/logout.php">Logout</a></li>
  <?php } 
else { ?>
    <li>
<a href="../login/login-user.php">Login</a>
       <a href="../login/register4.php">Register</a>
   </li>
    <?php } ?> 
      <li>
<form class="navbar-form navbar-left" role="search" method="post" action="../home">
    <div class="form-group">
        <input id="search" name="search" type="text" class="form-control" 
  placeholder="Search">
    </div>
    <button type="submit" class="btn btn-default">Submit</button>
</form>
     </li>
    </ul>
   </div>
                                                                            
