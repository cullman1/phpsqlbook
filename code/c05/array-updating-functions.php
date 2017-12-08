<h1>Order</h1>
<?php
// Create array and show contents as a string
$order = array('notebook', 'pencil', 'eraser');
array_unshift($order, 'scissors');    // Add to start
array_pop($order);                    // Remove last
echo implode(', ', $order) . '<br>';  // Show string
?>
<h1>Classes</h1>
<?php
// Create array holding classes
$classes = array('Patchwork' => 'April 12th',
                 'Knitting'  => 'May 4th',
                 'Lettering' => 'May 18th');

array_shift($classes);                // Remove first
$new = array('Origami' => 'June 5th');// Array to add
$classes = array_merge($classes, $new); // Add to end

foreach($classes as $description => $date) {
    echo $description . ': ' . $date . '<br>';
}
?>