<?php
error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', TRUE);
session_start();
use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\FacebookResponse;
use Facebook\FacebookSDKException;
use Facebook\FacebookRequestException;
use Facebook\FacebookAuthorizationException;
use Facebook\GraphObject;
use Facebook\Entities\AccessToken;
use Facebook\HttpClients\FacebookHttpable;
use Facebook\HttpClients\FacebookCurlHttpClient;
use Facebook\HttpClients\FacebookCurl;
FacebookSession::setDefaultApplication('838101672918431','8d77fe43aeac414752080cb768f01fff');
$helper = new FacebookRedirectLoginHelper( 'http://test1.phpandmysqlbook.com/code/chapter10/fbauthentication.php', '838101672918431', '8d77fe43aeac414752080cb768f01fff');
try {
  $session = $helper->getSessionFromRedirect();
  if ($session) {
    $accessToken = $session->getAccessToken();
    echo "Logged in<br/>";
    $session = new FacebookSession($accessToken);
    $request = new FacebookRequest($session, 'GET', '/me');
    $response = $request->execute();
    $user = $response->getGraphObject();
    echo "Name: ".$user->getProperty('name')."Email: ".$user->getProperty ('email')."<br/>";
  } else {    
    $permissions = array('email');
    $loginUrl = $helper->getLoginUrl($permissions); 
    header("location:".$loginUrl); 
  }
}
catch(FacebookSDKException $e) {
    $session = null;
    echo "Error ". $e;
} ?>