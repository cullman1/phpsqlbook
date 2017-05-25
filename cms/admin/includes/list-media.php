<?php
$media_list = get_media_list();
?>

<p><a href="media-create.php" class="btn btn-primary">Add new media</a></p>

<table class="table table-striped">
    <tr>
      <th>id</th><th>Thumbnail</th><th>Title</th><th>Filepath</th><th>Edit</th><th>Delete</th>
    </tr>
  <?php foreach ($media_list as $Media) { ?>
  <tr>
    <td><?= $Media->id;?></td>
    <td>
    <?php if ($Media->thumb != '') { ?>
      <img src="<?= $Media->thumb ?>" alt="<?= $Media->alt;?>"/>
    <?php } else { ?>
      <img src="uploads/placeholder.png" alt=""/>
    <?php } ?>
    </td>
    <td><?= $Media->title;?></td>
    <td><?= $Media->filepath;?></td>
    <td><a href="media-update.php?id=<?= $Media->id;?>" class="btn btn-primary">edit</a></td>
    <td><a href="media-delete.php?id=<?= $Media->id;?>" class="btn btn-danger">delete</a></td>
  </tr>
    <?php } ?>
  </tbody>
</table>

<p><a href="media-create.php" class="btn btn-primary">Add new media</a></p>