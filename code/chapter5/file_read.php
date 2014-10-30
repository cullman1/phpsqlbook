<?php
// Open the file
$file = @fopen("names.txt", 'r'); 

// Add each line to an array
if ($fp) {
   $row = explode("\n", fread($file, filesize("names.txt")));
   for ($i=0; i< count($row); i++)
   {
    $items = explode(",", $row[i]);
   }
}
?>

