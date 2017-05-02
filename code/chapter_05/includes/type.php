<?php $extra = 'round_type' . $count2 ?>
<select name="round_type<?php echo $count2; ?>">
    	<option value="PHP_ROUND_HALF_UP" <?php if($_POST[$extra]=='PHP_ROUND_HALF_UP') { echo "selected"; } ?>>PHP_ROUND_HALF_UP</option>
    	<option value="PHP_ROUND_HALF_DOWN" <?php if($_POST[$extra]=='PHP_ROUND_HALF_DOWN') { echo "selected"; } ?>>PHP_ROUND_HALF_DOWN</option>
    	<option value="PHP_ROUND_HALF_EVEN" <?php if($_POST[$extra]=='PHP_ROUND_HALF_EVEN') { echo "selected"; } ?>>PHP_ROUND_HALF_EVEN</option>
    	<option value="PHP_ROUND_HALF_ODD" <?php if($_POST[$extra]=='PHP_ROUND_HALF_ODD') { echo "selected"; } ?>>PHP_ROUND_HALF_ODD</option>
    </select>