<?php
require_once('includes/database-connnection.php'); 
require_once('../CMS/admin/includes/functions.php'); 
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- this file uses Twitter Bootstrap to create the modal window, so thee HTML follows their templates-->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../CMS/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/3.0.2/css/font-awesome.min.css">
    <title>All images</title>
  </head>
  <body>
    <h1> Media gallery</h1>
      <a class="btn btn-default btn-xs" data-toggle="modal" data-target="#imagesModal">
        <i class="icon-picture"></i> launch media gallery</a> <br>

      <?php include('includes/media-gallery.php'); ?>

    <script src="../CMS/js/jquery-1.12.0.js"></script>
    <script src="../CMS/js/bootstrap.min.js"></script>
  </body>
</html>