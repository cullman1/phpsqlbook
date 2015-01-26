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

    }
    catch(CurlException $e) {

        echo('exception caught '.$e->getMessage());
    }
    return $retData;
}

//App Info, needed for Auth
$app_id = "464651713667817";
//$app_id = "776930825674567";
$app_secret = "a8f67bca9e608806baf6a2fae8b53d5b";
$accessToken = $facebook->getAccessToken();
//Retrieve auth token

$authToken = fetchUrl("https://graph.facebook.com/oauth/access_token?grant_type=client_credentials&client_id=".$app_id."&client_secret=".$app_secret);
//$authToken = "access_token=464651713667817|LQjbRfAAK9FLRsShc_7F2kYWquQ";

$json_object = fetchUrl("https://graph.facebook.com/279377105567659/feed?".$authToken."&fields=id,message,from,type,picture,created_time,comments,link,likes&limit=5'");

$feedarray = json_decode($json_object);

$count=1;
echo "<div class='facebook_list2'><ol style='list-style-type:none;'>";
echo "<li style='padding-left:10px;padding-top:6px; '><img src='../images/facebook_logo2.png' width=200 /></li>";
echo '<li width=190 style="border-bottom: 1px solid #dddddd;padding-left:15px;padding-bottom:6px;"><div style="padding-left:15px;padding-bottom:5px;">East Cornwall Harriers page</div><div style="padding-left:32px;"><div class="fb-like" data-href="http://www.facebook.com/EastCornwallHarriersLiskeard" data-width="195" data-layout="button_count" data-action="like" data-show-faces="true" data-share="true"></div></div></li>';
echo "</ol></div><div class='facebook_list'><ol style='list-style-type:none;'>";
foreach ( $feedarray->data as $feed_data )
{  



    if(!($feed_data->type=="status" && $feed_data->message==""))
    {
        if(!($feed_data->type=="link"))
        {
            echo "<li><a href='".$feed_data->link."'>";
            
            
            //Message
            if($feed_data->type=="status" && $feed_data->message!="")
            {
                echo "<div style='color:#666;'>{$feed_data->message}</div>";
                
            }
            
            //Photo
            if($feed_data->type=="photo")
            {
                echo "<img src='{$feed_data->picture}'/><br/>";
            } 
            
            //Name and Date
            $unixTime = $feed_data->created_time;
            echo "<div style='font-weight:bold; font-size:11px;color:black; margin-top:5px;border-bottom: 1px solid #dddddd;'><img width=30 style='float:left;' src='https://graph.facebook.com/".$feed_data->from->id."/picture'/><span style='float:right; color:black;padding-bottom:4px;font-size:12px;'> {$feed_data->from->name}</span><br/><span style='font-size:11px;float:right;'>".date("F j, Y, g:i a", strtotime($unixTime))."</span><br/><span>&nbsp;</span></div>";
            
            
            //Likes
            $likes=0;
            $likes2=0;
            foreach ($feed_data->likes->data as $feed_likes )
            {    
                $likes++;
                
                $likes2 = $likes-1;
                if($likes==1)
                {
                    echo " <div style='font-size:10px;color:#666; background:#f6f7f8; margin-top:5px;'><img src='../images/fb_like_thumb.jpg'/> <span style='position:relative; top: -1px;'> {$feed_likes->name}";
                }
            }
            if($likes>2)
            {
                echo " and ".$likes2." other people like this post</span></div>";
            }
            else if($likes==2)
            {
                echo " and ".$likes2." other person likes this post</span></div>";
            }
            else if($likes==1)
            {
                echo " likes this post</span></div>";
            }
            else
            {
                //echo "<div style='font-size:10px;color:#666; background:#f6f7f8; margin-top:5px'><span style='position:relative; top: -1px;'> Be the first to like this post</span></div>";
            }
            
            
            
            //Comments
            if(isset($feed_data->comments))
            {
                foreach  ( $feed_data->comments->data as $feed_comments)
                {
                    $unixTime = $feed_comments->created_time;
                    echo "<div style='font-weight:bold; font-size:10px;margin-top:5px;padding-left:5px; background:#f6f7f8;color:#666; border-bottom: 1px solid #dddddd;'>{$feed_comments->message}</div>";
                    echo "<div style='font-weight:bold; font-size:10px;color:black; padding-top:5px;padding-left:5px;background:#f6f7f8; padding-bottom: 5px; '><img width=22 style='float:left' src='https://graph.facebook.com/".$feed_comments->from->id."/picture'/><span style='float:right; color:black'> {$feed_comments->from->name}</span><br/><span style='float:right; font-size:10px;background:#f6f7f8; padding-bottom: 5px;'>".date("F j, Y, g:i a", strtotime($unixTime))."</span><br/></div>";
                    
                    //echo "<div style='font-size:10px; background:#f6f7f8;'>".date("F j, Y, g:i a", strtotime($unixTime))."</div>";
                }
            }
            
            echo "</a></li>";
        }
    }
    $count++;
    if($count>5) { break;}
}
echo "</ol></div>";

?>