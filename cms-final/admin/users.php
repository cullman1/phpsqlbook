<?php
require_once '../config.php';

$userManager->redirectNonAdmin();

  $user_list   = $userManager->getAllUsers();

  include 'includes/header.php';
?>

<section>

  <a class="btn btn-primary" href="user.php?action=create">create user</a>

  <table class="table">
    <thead>
      <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Joined</th>
        <th></th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <?php  foreach ($user_list as $user) { ?>
      <tr>
        <td><?= $user->getFullName() ?></td>
        <td><?= $user->email ?></td>
        <td><?= $user->joined ?></td>
        <td><a class="btn btn-primary" href="user.php?action=update&id=<?= $user->id?>">edit</a></td>
        <td><a class="btn btn-danger" href="user-delete.php?id=<?= $user->id?>">delete</a></td>
      </tr>
      <?php } ?>
    </tbody>
  </table>

</section>

<?php include 'includes/footer.php'; ?>