<?php
session_start();
include "bin/config.php";
require_once __DIR__ . '/vendor/autoload.php';
$accesso= new Config();

$fb = new Facebook\Facebook([
  'app_id' => $accesso->get_id(),
  'app_secret' => $accesso->get_secret(),
  'default_graph_version' => $accesso->get_version()
]);

$helper = $fb->getRedirectLoginHelper();
$permissions = ['email', 'user_likes']; // optional
$loginUrl = $helper->getLoginUrl('https://www.nslatino.com/nscomment/login/procesaLogin.php', $permissions);
echo '<a href="' . $loginUrl . '">Log in with Facebook!</a>';










?>
