<?php

error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', TRUE);
include('class_lib.php');

function low_stock($stock_number, $stock_warning) {
  if ($stock_number > $stock_warning) {

    return $stock_number . ' available';
  } else {
    return '<span class="red">LOW STOCK only ' . $stock_number . ' left' . '</span>';
  }
}


$pakchoi_image = array('name'=>'pak-choi.jpg','alt'=>'A whole pak choi');
$chives_image = array('name'=>'chives.jpg','alt'=>'A cutting of chives');
$dill_image = array('name'=>'dill.jpg','alt'=>'A leafy clump of dill');
$carrots_image = array('name'=>'carrots.jpg','alt'=>'A bunch of carrots');

$pakchoi = new Seed('Pak Choi', 5, 7, $pakchoi_image);
$chives = new Seed('Chives', 4, 56, $chives_image);
$dill = new Seed('Dill', 3, 14, $dill_image);
$carrots = new Seed('Carrots', 2, 8, $carrots_image);
$seeds = array($pakchoi, $chives, $dill, $carrots);

include 'header-admin.php'; ?>
<div style="padding-left:10px;">
<table >
  <tr>
    <th>Product</th>
    <th style="text-align:center;">Cost</th>
    <th style="text-align:left; padding-left:40px;">Stock</th>
    
  </tr>
  <?php
    foreach ($seeds as $seed) {
      echo '<tr>';
      echo '<td><img width=100 alt="'. $seed->getImageAlt() . '" title="'. $seed->getImageAlt() . '" src="'. $seed->getImageThumbnail() . '" /><br>'; 
    
      foreach ($seed as $property => $value) {
       echo $property . ': ' . $value . '<br>';
      }
      echo '<td valign=bottom style="text-align:left; padding-left:40px;">$' . $seed->getPrice() . '</td>';
      echo '<td valign=bottom style="text-align:left; padding-left:40px;">' . low_stock($seed->getStock(), 10) . '</td>';
    echo '</tr>';
   }
?>
</table>
</div>