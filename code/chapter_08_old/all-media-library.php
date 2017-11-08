<?php
require_once('includes/database-connnection.php'); 
require_once('includes/functions.php'); 
$message = '';
$orderby   = ( isset($_GET['orderby'])   ? $_GET['orderby']    : '' );
$direction = ( isset($_GET['direction']) ? $_GET['direction']  : '' );
include 'includes/header.php';

?>

<div class="container" role="main">
  <?php $media_list = get_media_list($orderby, $direction);
  foreach ($media_list as $media) {                          // Loop through media ?> 
  <div class="col-md-3" id="thumbnails">
    <div class="panel panel-default">
      <div class="panel-heading"><?=$media->title?></div>
      <div class="panel-body"><?= display_media($media); ?></div>
    </div>
  </div>
<?php } ?>
</div><!-- .container -->
<?php include 'includes/footer.php'; ?>