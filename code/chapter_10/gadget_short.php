<?php
function fetchUrl($url){
  $retData="";
  try {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 20);
    $retData = curl_exec($ch);
    if(curl_errno($ch)){
      echo '<br/>Curl error: ' . curl_error($ch);
    }
    curl_close($ch);
  } catch(CurlException $e) {
    echo('exception caught '.$e->getMessage());
  }
return $retData;
}
$app_id = "464651713667817";
$app_secret = "a8f67bca9e608806baf6a2fae8b53d5b";
$authToken = fetchUrl("https://graph.facebook.com/oauth/access_token?grant_type=client_credentials&client_id=".$app_id."&client_secret=".$app_secret);
$json_object = fetchUrl("https://graph.facebook.com/279377105567659/feed?".$authToken."&fields=id,message,from,type,picture,created_time,comments,link,likes&limit=5'");
$feedarray = json_decode($json_object);
echo "<div class='facebook_list list_box'><ol style='list-style-type:none;'>";
foreach ( $feedarray->data as $feed_data ) {
    if (isset($feed_data->message)) {
        if(!($feed_data->type=="status" && $feed_data->message=="")) {
            if(!($feed_data->type=="link"))      {
                if(isset($feed_data->link)) {
                    echo "<li><a href='".$feed_data->link."'>";
                }               
                if($feed_data->type=="status" && $feed_data->message!="")  {
                    echo "<div class='gray'>{$feed_data->message}</div>"; 
                }
                if($feed_data->type=="photo") {
                    echo "<img src='{$feed_data->picture}'/><br/>";
                }
                $unixTime = $feed_data->created_time;
                echo "<div class='img_box'><img width=30 class='left' src='https://graph.facebook.com/".$feed_data->from->id."/picture'/>";
                echo "<span class='name_box'> {$feed_data->from->name}</span><br/>";
                echo "<span class='right_box'>".date("F j, Y, g:i a", strtotime($unixTime))."</span><br/><span>&nbsp;</span></div>";
                $likes=0;
                if(isset($feed_data->likes)) {
                    foreach ($feed_data->likes->data as $feed_likes ) {    
                        $likes++;
                        if($likes==1) {
                            echo " <div class='likes_box'><img src='../images/fb_like_thumb.jpg'/> <span>";
                        }
                    }
                    if($likes>1){
                        echo $likes." people like this post</span></div>";
                    }
                    else if($likes==1) {
                        echo $likes." person likes this post</span></div>";
                    }
                    else {
                        echo "<div class='first_box'><span> Be the first to like this post</span></div>";
                    }
                }
                if(isset($feed_data->comments)) {
                    foreach  ( $feed_data->comments->data as $feed_comments) {
                        $unixTime = $feed_comments->created_time;
                        echo "<div class='cmt_box1'>{$feed_comments->message}</div>";
                        echo "<div  class='cmt_box2'><img width=22 class='left' src='https://graph.facebook.com/".$feed_comments->from->id. "/picture'/>";
                        echo "<span class='right_box'> {$feed_comments->from->name }</span><br/>";
                        echo "<span class='date_box'>".date("F j, Y, g:i a", strtotime($unixTime))."</span><br/></div>";
                    }
                }
                echo "</a></li>";
            }
        }
    }
}
echo "</ol></div>"; ?>

