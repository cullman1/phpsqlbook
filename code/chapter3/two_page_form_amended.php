


<?php include '../includes/header-register.php' ?>
<form name="input_form" method="post" action="submit_form_2.php">
      <div class="wholeform">
      <div class="col-md-4"><h1>Two Page Form Submit</h1>
<label for="full_name">Full Name:</label> 
<input type="text" id="full_name" name="full_name" /><br />
<input type="submit" name="submit_button" value="Submit" />
       </div>
            <div>
        <?php
if (!empty($_REQUEST["full_name"]))
{
	echo "<br/>Hello ".$_REQUEST["full_name"].", welcome to our site";
}
?>
    </div>
</div>
</form>
<?php include '../includes/footer-register.php' ?>
