<?php session_start();
error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', TRUE);
  require_once('../classes/registry.php');
  require_once('../classes/configuration.php');
  require_once('../classes/urlhandler.php');
  require_once('../classes/controller.php');
  $registry = Registry::instance();
  $registry->set('urlhandler', new UrlHandler());
  $urlhandler = $registry->get('urlhandler');
  $urlhandler->routeRequest();?>