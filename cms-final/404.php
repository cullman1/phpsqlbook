<?php

require_once("config.php");
$single_byte_string_length        = strlen('$$$100');  
$multi_byte_string_length = mb_strlen('ööö00');
echo $single_byte_string_length;
echo $multi_byte_string_length;

mb_internal_encoding("iso-8859-1");
echo "ヒタミ";
$text = " Il était un château,  Weiß, Goldmann, Göbel, Weiss, Göthe, Goethe und Götz < > ' \" ";
   $config = HTMLPurifier_Config::createDefault();
    $purifier = new HTMLPurifier($config);
    $config->set('Core.Encoding', 'UTF-8'); // replace with your encoding
    $config->set('HTML.Allowed', 'p,strong,em,u,strike'); // replace with your doctype
    $clean_html = $purifier->purify($text);
    echo htmlentities($text, ENT_NOQUOTES, 'UTF-8');

?>
<span style="<?=  htmlentities($text, ENT_NOQUOTES, 'UTF-8') ?>"></span>
  