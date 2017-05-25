<?php
$user_list = get_user_list();
?>

<p><a href="user-create.php" class="btn btn-primary">Add new user</a></p>

<table class="table table-striped">
  <tr>
    <th>Profile picture</th><th>ID</th><th>Name</th><th>Email</th><th>Date Joined</th><th></th><th></th>
  </tr>
  <?php foreach ($user_list as $user) { ?>
  <tr>
    <td><?=$user->image;?></td>
    <td><?=$user->id;?></td>
    <td><?=$user->forename;?> <?=$user->surname;?></td>
    <td><?=$user->email;?></td>
    <td><?=$user->joined;?></td>
    <td><a href="user-edit.php?action=edit&user_id=<?=$user->id;?>" class="btn btn-primary">edit</a></td>
    <td><a href="user-edit.php?action=delete&user_id=<?=$user->id;?>" class="btn btn-danger">delete</a></td>
  </tr>
    <?php } ?>
</table>

<p><a href="user-create.php" class="btn btn-primary">Add new user</a></p>