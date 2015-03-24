<?php 
$planting = array(
    sew => "April",
    harvest => "June",
    light => "Full"
);
?>
<!DOCTYPE html>
<html>
<head>...</head>
<body>
  <p>Sew <?php echo $planting['sew']; ?></p>
  <p>Harvest <?php echo $planting['harvest']; ?></p>
  <p>Light <?php echo $planting['light']; ?>.</p>
</body>
</html>