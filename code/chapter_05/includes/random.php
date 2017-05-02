<?php $extra = 'rando' . $count3 ?>
<select name="rando<?php echo $count3; ?>">
    	<?php for($i=0; $i<=100; $i++) { ?>
<option value="<?php echo $i; ?>" <?php if($_POST[$extra]==$i) { echo "selected"; } ?> ><?php echo $i; ?> </option>
<?php } ?>
    </select>