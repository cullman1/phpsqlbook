<?php
error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', TRUE);
require_once('includes/database-connnection.php'); 
require_once('includes/functions.php'); 
include 'includes/header.php';
$message = '';
$gallery_list = get_gallery_list(); ?>
<div class="container" role="main">
  <a href="gallery-edit.php?action=add" class="btn btn-primary">Add gallery</a><br/><br/>
  <table class='table table-striped'>
    <tr>
      <th>Gallery Title</th>
      <th>Mode</th>
      <th>Edit?</th>
    </tr>
    <?php foreach ($gallery_list as $gallery) { ?>
      <tr>
        <td><?=$gallery->name;?></td>
        <td><?=$gallery->mode;?></td>
        <td><a href="gallery-edit.php?action=edit&gallery_id=<?=$gallery->id;?>"  
        class="btn btn-primary"><span class="icon-pencil"></span></a></td>
      </tr>
    <?php } ?>
  </table>
</div> <!-- .container -->

<?php include 'includes/footer.php'; ?>