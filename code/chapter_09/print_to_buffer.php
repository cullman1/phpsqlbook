<?php
ini_set('display_errors', TRUE);
  $content = "Important";
  $html1 = "<span style='color:red'>**</span>";
 
  function buffer($html, $content) {
    ob_start();
    echo $content;
    $content=ob_get_clean();
    return $html . $content;
  }

  echo(buffer($html1, $content));

 ?>