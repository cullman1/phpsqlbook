<?php
function customException($Exception) {
//Redirect to custom error page
header('Location:../error/customerror.html');
}

set_exception_handler("customException");

throw (
?>