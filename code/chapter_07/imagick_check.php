<?php
if(extension_loaded('imagick')) {
    $im = new Imagick();
    echo($im->queryFormats());
}
else {
    echo 'ImageMagick is installed.';
}
?>