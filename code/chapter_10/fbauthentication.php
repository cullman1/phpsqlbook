<?php
error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', TRUE);
session_start();
require_once("../vendor/autoload.php");
use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\FacebookResponse;
use Facebook\FacebookSDKException;
use Facebook\FacebookRequestException;
use Facebook\Entities\AccessToken;

FacebookSession::setDefaultApplication('838101672918431','8d77fe43aeac414752080cb768f01fff');
$helper = new FacebookRedirectLoginHelper( 'http://test1.phpandmysqlbook.com/code/chapter_10/fbauthentication.php', '838101672918431', '8d77fe43aeac414752080cb768f01fff');
try {
  $session = $helper->getSessionFromRedirect();
  if ($session) {
    $accessToken = $session->getAccessToken();
    echo "Logged in<br/>";
    $fbsession = new FacebookSession($accessToken);
    $request = new FacebookRequest($fbsession, 'GET', '/me');
    $response = $request->execute();
    $user = $response->getGraphObject();
    echo "Name: ".$user->getProperty('name')."<br/>Email: ".$user->getProperty ('email');
  } else {    
    $permissions = array('email');
    $loginUrl = $helper->getLoginUrl($permissions); 
    header("location:".$loginUrl); 
  }
}
catch(FacebookSDKException $e) {
    $fbsession = null;
    echo "Error ". $e;
} ?>