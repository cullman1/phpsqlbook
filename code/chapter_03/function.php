<?php
function write_copyright_notice() {
$year = date('Y'); // Get and store year
echo '&copy; ' . $year; // Write copyright notice
}
?>
<!doctype html>
<html>
...
<div class="footer">
<?php write_copyright_notice(); ?>
</div>
...
</html>