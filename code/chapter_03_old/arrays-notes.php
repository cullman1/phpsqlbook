<?php

/* 
Arrays store what are known as key/value pairs
array() creates the array

array_unshift()	Adds one or more items to the start of an array.
array_push()	Adds one or more items to the end of an array.
array_shift()	Removes the first item from the array.
array_pop()		Removes the last item from the array.

array_count()	Number of items in the array

$order = array('carrot', 'courgette', 'french beans')
array_unshift($seeds, 'tomato');
array_push($seeds, 'aubergine', 'spinach');
array_shift($seeds);
array_pop($seeds);


array_diff()		compares two arrays and shows differences in an array

array_fill()		fills the array with values

array_keys() 		returns all keys
array_key_exists() 	checks that a key exists
array_flip()		swaps keys for values


array_product() 	adds all the values in the array

array_rand()		selects random item from the array (or more)
array_search()		Search array for a value and return the key for that item

array_count_values()	returns an array with the number of items for each value in the array


SORTING ARRAYS
array_reverse()		Reverse order of the array


*/
// Here is an array
$order = array("carrot", "courgette", "french beans");
// You can turn an array into a string, with a separating character using implode("text separator", array);
// Once you use that method it is no longer an array. To turn it back into an array you would use explode("text separator", array);

print_r($order);
echo '<br><br>';
var_dump($order);
echo '<br><br>';
var_export($order);
echo '<br><br>';

echo implode(", ", $order) . '<br>';
explode(", ", $order);

array_unshift($order, 'tomato');
array_push($order, 'aubergine', 'spinach');
echo implode(", ", $order) . '<br>';

explode(", ", $order);
array_shift($order);
array_pop($order);
echo implode(", ", $order) . '<br>';

explode(", ", $order);

echo array_rand($order) . '<br>'; // Shows the index of that item
echo $order[array_rand($order)] . '<br>'; // Shows a random item

echo array_search('courgette', $order, true); //		Search array for a value and return the key for that item - second item because it is zero based - last parameters says that it must be the same type as well as value - if nothing it will continue processing the script

if (in_array("aubergine", $order)) {
    echo "You have aubergine" . '<br>';
}
if (in_array("tomato", $order)) {
    echo "You have tomato" . '<br>';
}
// add count values here

/// actually this should probably be sorting - will look nice with numbers
// 1 3 5 7 
echo implode(", ", array_reverse($order));

?>