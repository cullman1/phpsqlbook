<?php
error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', TRUE);
include('class_lib.php');
$basil = new Seed('Basil', 3, 32);
$chives = new Seed('Chives', 4, 56);
$parsley = new Seed('Parsley', 3, 14);
?>
<table>
<tr>
<th>Date</th>
<th><?php echo $basil->name; ?></th>
<th><?php echo $chives->name; ?></th>
<th><?php echo $parsley->name; ?></th>
</tr>
<tr style="background-color:gray;">
<td>23 June</td>
<td><?php echo $basil->stock; ?></td>
<td><?php echo $chives->stock; ?></td>
<td><?php echo $parsley->stock; ?></td>
</tr>
<?php
$basil->updateStock(3);
$chives->updateStock(-12);
$parsley->updateStock(50);
?>
<tr>
<td>24 June</td>
<td><?php echo $basil->stock; ?></td>
<td><?php echo $chives->stock; ?></td>
<td><?php echo $parsley->stock; ?></td>
</tr>
<?php
$basil->updateStock(3);
$chives->updateStock(-12);
$parsley->updateStock(50);
?>