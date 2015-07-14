<?php include '../includes/header-facebook.php';
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
echo "<div class='fb_list list_box'><ol class='none'>";
foreach ($feedarray->data as $apidata ){
 if (isset($apidata->message)) {
  if(!($apidata->type=="status" && $apidata->message=="")){
   if(!($apidata->type=="link"))      {
    if(isset($apidata->link)) {
     echo "<li><a href='".$apidata->link."'>";
    }               
    if($apidata->type=="status" && $apidata->message!=""){
     echo "<div class='gray'>{$apidata->message}</div>"; 
    }
    if($feed_data->type=="photo") {
     echo "<img src='{$apidata->picture}'/><br/>";
    }
   echo "<div class='img'><img src='https://graph.facebook.com/".$apidata->from->id."/picture' class='left30' />";
    echo "<span class='name_box'> {$apidata->from->name}</span><br/>";
   $unixTime = $apidata->created_time;
    echo "<span class='rbox'>".date("F j, Y, g:i a", strtotime($unixTime))."</span><br/><span>&nbsp;</span></div>";
    $likes=0;
  if(isset($apidata->likes)) {
   foreach ($apidata->likes->data as $apilikes ) {    
      $likes++;
    if($likes==1) {
       echo "<div class='likes_box'>";
       echo "<img src='../images/fb_like_thumb.jpg'/><span>";
      }
     }
   if($likes>1){
      echo $likes." people like this post</span></div>";
     } else if($likes==1) {
      echo $likes." person likes this post</span></div>";
     } else {
      echo "<div class='first_box'><span>"; 
      echo "Be the first to like this post</span></div>";
     }
    }
  if(isset($apidata->comments)) {
     foreach  ($apidata->comments->data as $apicmtdata) {
      $unixTime = $apicmtdata->created_time;
    echo "<div class='cmt1'>{$apicmtdata->message}</div>";
      echo "<div class='cmt2'><img width=22 class='left' src='https://graph.facebook.com/" .$apicmtdata->from->id. "/picture'/>";
      echo "<span class='rbox'>{$apicmtdata->from->name}</span>";
      echo "<span class='date_box'>".date("F j, Y, g:i a",strtotime($unixTime))."</span></div>";
     }
    }
   echo "</a></li>";
   }
  }
 }
}
echo "</ol></div>"; 
 ?>
