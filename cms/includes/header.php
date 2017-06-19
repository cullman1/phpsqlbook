<!DOCTYPE html>
<html>
<head>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>  
 <link rel="stylesheet" type="text/css" href="/phpsqlbook/cms/css/styles.css"/>
 <link href='https://fonts.googleapis.com/css?family=Caudex:400,700|Gilda+Display'   
  rel='stylesheet' type='text/css'>
    <script src="https://use.fontawesome.com/c59bfa691d.js"></script>
</head>
<body>
 <header>
  <h1>the green room</h1>
   <nav><a href="/phpsqlbook/cms/">Home</a><?php echo get_menu();  ?>
     <form id=form1 style="float:right;" class="navbar-form navbar-left" role="search"  method="get"action="\phpsqlbook\cms\search">
      <input id="term" name="term" type="text" />
    <input type="submit">
   <?php 
    if (isset($_SESSION["user_id"])) {      ?>
   Hello <a class="link-style" href="/phpsqlbook/cms/profile?id=<?php echo $_SESSION["user_id"]; ?>"><?php echo $_SESSION["name"];?></a>&nbsp;  
      <a href="/phpsqlbook/cms/admin">Admin</a>
    <a href="/phpsqlbook/cms/logout">Logout</a>
   <?php } else {    ?>             
   <a href="/phpsqlbook/cms/login">Login</a>&nbsp;
   <a href="/phpsqlbook/cms/register">Register</a>
    <?php } ?> 
   </form></nav>
</header><div class="content-page">