<h1>Order</h1>
<?php
$order = array('notebook', 'pencil', 'scissors',
               'eraser', 'ink', 'washi tape');
sort($order);
echo implode(', ', $order);
?>

<h1>Classes</h1>
<?php
// Create array holding classes
$classes = array('patchwork' => 'April 12th',
                 'knitting'  => 'May 4th',
                 'origami'   => 'June 8th');
ksort($classes);

foreach($classes as $description => $date) {
    echo $description . ': ' . $date . '<br>';
}
?>