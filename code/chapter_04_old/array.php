<?php
include("class_lib.php");

//Create an array to store in the property
$number1 = array('sortcode'=>402355,'iban'=>12345678);
$number2 = array();
$number2[0] = 402355;
$number2[1] = 12345678;

//Create an instance of the class and set properties
$account1 = new Account('Ivy Savings', $number1, 100);
$account2 = new Account('Dougal Savings', $number2, 10);

//Associative array in property
echo $account1->name;
echo '<br>' . $account1->number['sortcode'];
echo '<br>' . $account1->number['iban'];

//Indexed array in property
echo '<br>' . $account2->name;
echo '<br>' . $account2->number[0];
echo '<br>' . $account2->number[1];

?>