<?php
 include 'cookie-include.php'; 
 include 'cookie-menu.php';
?>
<div class="tk-proxima-nova" style="padding-left:10px; float:left;">
<form name="input_form" method="post" action="preferences.php"> 
  <h3 class="tk-proxima-nova">Profile</h3>
    <br/>
    <label>Username: <input type="text" name="username" value="<?=$username; ?>"/></label>
        <br/>    
         <br/>   
        <label for="full_name">Color scheme:
            <select id="color" name="color">
                <option value="">Choose color</option>
         
                <option value="#ccede9" <?php if ($color=="#ccede9") { echo "selected"; }?> >mint</option>
                <option value="#cceefb" <?php if ($color=="#cceefb") { echo "selected"; }?> >forget-me-not</option>
                <option value="#fcdfdb" <?php if ($color=="#fcdfdb") { echo "selected"; }?> >salmon</option>
                <option value="#e6e3e1" <?php if ($color=="#e6e3e1") { echo "selected"; }?> >monochrome</option>
            </select>
        </label> 
    <br />
    <br />
    <input type="submit" name="submit_button" value="Save" />
</form>
</div>
