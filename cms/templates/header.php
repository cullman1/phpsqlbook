<!DOCTYPE html>
<html>
<head>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>  
 <link rel="stylesheet" type="text/css" href="/cms/css/styles.css"/>
 <link href='https://fonts.googleapis.com/css?family=Caudex:400,700|Gilda+Display'   
  rel='stylesheet' type='text/css'>
</head>
<body>
 <header>
  <h1>the green room</h1>
   <nav><a href="/">Home</a><?php echo getMenu();  ?>
     <form id=form1 style="float:right;" class="navbar-form navbar-left" role="search"  method="get"action="\phpsqlbook\cms\search">
      <input id="term" name="term" type="text" />
    <input type="submit">
   </form></nav>
</header>