<?php
require_once('includes/database-connnection.php'); 
require_once('includes/functions.php'); 
$message = '';
$orderby   = ( isset($_GET['orderby'])   ? $_GET['orderby']    : '' );
$direction = ( isset($_GET['direction']) ? $_GET['direction']  : '' );
include 'includes/header.php';
$media_list = get_media_list($orderby, $direction);
?>

<div class="container" role="main">
  <div class="page-header"><h2>media</h2></div>
<table class='table table-striped'>
  <?php foreach ($media_list as $media) { ?>
  <tr>
    <td><?=$media->title;?></td>
    <td><?=display_media($media);?></td>
    <td><?=$media->type;?></td>
  </tr>
    <?php } ?>
</table>
</div><!-- .container -->
<?php include 'includes/footer.php'; ?>