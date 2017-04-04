<?php
if (!empty($_REQUEST["full_name"]))
{
	header('Location:two_page_form_amended.php?full_name='.$_REQUEST["full_name"]);
}
?>

