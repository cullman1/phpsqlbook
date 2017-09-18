<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
  </head>
  <body>
  <div class="container">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <a class="navbar-brand" href="<?= ROOT ?>"><?= $site_name ?></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
          <a href="articles.php" class="nav-item nav-link">articles</a>
          <a href="categories.php" class="nav-item nav-link">categories</a>
          <a href="users.php" class="nav-item nav-link">users</a>

          <?php if ($is_logged_in) { ?>
            <span class="nav-item">Hello <?= $_SESSION["name"] ?></span>
            <a class="nav-item nav-link" href="<?= ROOT ?>users/logout.php">Logout</a></a>
          <?php  } else { ?>
            <a href="<?= ROOT ?>users/login.php">Login</a>
          <?php } ?>

        </div>
      </div>


    </nav>