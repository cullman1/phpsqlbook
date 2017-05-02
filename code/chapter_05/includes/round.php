<?php $extra = 'dp' . $count1; ?>
<select name="dp<?php echo $count1; ?>">
        <option value="0" <?php if($_POST[$extra]==0) { echo "selected"; } ?>>0</option>
    	<option value="1" <?php if($_POST[$extra]==1) { echo "selected"; } ?>>1</option>
    	<option value="2" <?php if($_POST[$extra]==2) { echo "selected"; } ?>>2</option>
    	<option value="3" <?php if($_POST[$extra]==3) { echo "selected"; } ?>>3</option>
        <option value="4" <?php if($_POST[$extra]==4) { echo "selected"; } ?>>4</option>
    </select>