<?php
error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', TRUE);
session_start();

require_once( '../Facebook/FacebookSession.php' );
require_once( '../Facebook/FacebookRedirectLoginHelper.php' );
require_once( '../Facebook/FacebookRequest.php' );
require_once( '../Facebook/FacebookResponse.php' );
require_once( '../Facebook/FacebookSDKException.php' );
require_once( '../Facebook/FacebookRequestException.php' );
require_once( '../Facebook/FacebookAuthorizationException.php' );
require_once( '../Facebook/GraphObject.php' );

use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\FacebookResponse;
use Facebook\FacebookSDKException;
use Facebook\FacebookRequestException;
use Facebook\FacebookAuthorizationException;
use Facebook\GraphObject;


$helper = new FacebookRedirectLoginHelper('http://test1.phpandmysqlbook.com/pages/facebookexample.php', '838101672918431', '8d77fe43aeac414752080cb768f01fff');
$loginUrl = $helper->getLoginUrl();
header('Location:'.$loginUrl);
//Get User ID
try {
    $session = $helper->getSessionFromRedirect();
} catch(FacebookSDKException $e) {
    echo "Error ";
    $session = null;
    echo "Error ". $e;
}

if ($session) {
    // User logged in, get the AccessToken entity.
    $accessToken = $session->getAccessToken();
    $session = new FacebookSession($accessToken);
    
    $user_profile = (new FacebookRequest(      $session, 'GET', '/me' ))->execute()->getGraphObject(GraphUser::className());

    echo "Name: " . $user_profile->getName();
}
else
{
    
    echo "No Session";
}
//require 'facebooksidebar.php';

 ?>
