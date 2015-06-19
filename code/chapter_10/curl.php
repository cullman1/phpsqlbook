<?php
try {
    $url="https://api.instagram.com/v1/users/2036987812/media/recent/?client_id=291142a4ca83449595c8b758707f065f";
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 20);
    $result = curl_exec($ch);
    if(curl_errno($ch)){
        echo '<br/>Curl error: ' . curl_error($ch);
    }
    curl_close($ch);
    $jsonData = json_decode($result);
    foreach ($jsonData->data as $key=>$value) {
        $images .= '<img src="'.$value->images->low_resolution->url.'"/> ';
    }
    echo $images;
}
catch(CurlException $e) {
    echo('exception caught'.$e->getMessage());
}
?>