<?php $gallery_list = get_gallery_list(); ?>

<p><a href="gallery-create.php" class="btn btn-primary">Add new gallery</a></p>

<table class="table table-striped">
  <tr>
    <th>id</th><th>Name</th><th>Gallery type</th><th>Edit</th><th>Delete</th>
  </tr>

  <?php foreach ($gallery_list as $Gallery) {
  $Media = $Gallery->getFirstImage() ?>
  <tr>
    <td>
      <?php if ( isset($Media->thumb) ) { ?>    
        <img src="<?=$Media->thumb;?>" alt="<?=$Gallery->alt;?>" />
      <?php } ?>
    </td>
    <td><?=$Gallery->name;?></td>
    <td>
      <?php echo $Gallery->getGalleryModeName(); ?>
    </td>
    <td><a href="gallery-update.php?id=<?=$Gallery->id;?>" class="btn btn-primary">edit</a></td>
    <td><a href="gallery-delete.php?id=<?=$Gallery->id;?>" class="btn btn-danger">delete</a></td>
  </tr>
<?php 
} 
?>

</table>

<p><a href="gallery-create.php" class="btn btn-primary">Add new gallery</a></p>