<?php
error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', TRUE);
include('class_lib.php');
$basil = new Seed('Basil', 3, 32);
?>
<!DOCTYPE html>
<html>...
<body>
<h1><?php echo $basil->name; ?></h1>
<?php
foreach ($basil as $property => $value) {
echo $property . ' ' . $value . '<br>';
}
?>
</body>
</html>