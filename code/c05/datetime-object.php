<?php
  $now = new DateTime();

  $expires = new DateTime('2020-12-31 23:59');
?>

<p>Current time: 
<?php echo $now->format('D d M Y, g:i a'); ?>
</p>

<p>Offer expires on 
  <?php echo $expires->format('D d M Y'); ?>
  at 
  <?php echo $expires->format('g:i a'); ?>
</p>