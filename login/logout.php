<?php
session_start();
include "./../bin/config.php";
require_once __DIR__ . './../vendor/autoload.php';
$accesso= new Config();

$fb = new Facebook\Facebook([
  'app_id' => $accesso->get_id(),
  'app_secret' => $accesso->get_secret(),
  'default_graph_version' => $accesso->get_version()
]);

$helper = $fb->getRedirectLoginHelper();
$logoutUrl = $helper->getLogoutUrl($_SESSION['facebook_access_token'], 'https://www.nslatino.com/nscomment/index.php');
session_destroy();
$redirigir="Location: ".$logoutUrl;
header($redirigir);
