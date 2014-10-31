<?php
$names = file_get_contents("namesonly.txt");
echo $names."<br/>";
$names2 = file("namesonly.txt");

for ($i=0; $i<count($names2); $i++) {
   
        echo $names2[$i]."<br/>";
}
?>