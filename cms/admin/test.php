GD: 
<?php
if (extension_loaded('gd') && function_exists('gd_info')) {
  echo "installed";
}
else {
  echo "not installed";
}
?>
<br>

ImageMagick: 
<?php
if(extension_loaded('imagick')) {
    $im = new Imagick();
    echo 'installed';
} else {
    echo 'not installed';
}
?>
<br>

PHP INFO:
<?php phpinfo() ?>


/*

To install ImageMagick on Mac OSX:
Install XQuartz https://www.xquartz.org
Then install imagemagick binary from cactussoft

*/