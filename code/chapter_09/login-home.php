<?php 
include 'session-include.php'; 
 include 'cookie-include.php'; 
 include 'login-menu.php';
?>
<div class="tk-proxima-nova" style="padding:10px;float:left;">Welcome to the home page!</div>

<?php 
 
function searchForId($id, $array) {
    foreach ($array as $key => $val) {
        if ($val['uid'] === $id) {
            return $key;
        }
    }
    return null;
}

 include 'recently-viewed.php'; ?>