<?php
  $content = "Important";
  $html1 = "<span class='red'>**</span>";

  function buffer($html, $content) {
    ob_start();
    echo $content;
    $content=ob_get_clean();
    return $html . $content;
  }

  echo(buffer($html1, $content));
?>