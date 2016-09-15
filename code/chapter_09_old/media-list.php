<?php
require_once('../includes/database-connnection.php'); 
require_once('includes/functions.php'); 
$message = '';
$media_list = get_images_list();
include 'includes/header.php';
?>

<div class="panel">

<div class="new"><a href="media-edit.php?action=add" class="button">Add media</a></div>

<table>
  <tr>
    <th>Thumb</th><th>Title</th><th>Filename</th><th></th><th></th>
  </tr>
  <?php foreach ($media_list as $media) { ?>
  <tr>
    <td><img src="../<?=$media->filepath;?>" alt="<?=$media->alt;?>" /></td>
    <td><?=$media->title;?></td>
    <td><?=$media->filename;?></td>
    <td><a href="media-edit.php?action=edit&media_id=<?=$media->id;?>" class="button">edit</a></td>
    <td><a href="media-edit.php?action=delete&media_id=<?=$media->id;?>" class="button confirmation">delete</a></td>
  </tr>
    <?php } ?>
</table>
</div>

<?php include 'includes/footer.php'; ?>