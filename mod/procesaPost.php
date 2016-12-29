<?php
session_start();
include "./../bin/config.php";
require_once __DIR__ . './../vendor/autoload.php';
$accesso= new Config();

$fb2 = new Facebook\Facebook([
  'app_id' => $accesso->get_id(),
  'app_secret' => $accesso->get_secret(),
  'default_graph_version' => $accesso->get_version()
]);

$post=$_POST['id_post'];
$id=$_POST['id'];
$recurso=$id."_".$post;
$res = [];
$fb2->setDefaultAccessToken($_SESSION['facebook_access_token']);
try {
  $response = $fb2->get('/'.$recurso.'/comments?fields=from,message,comment_count');
  $postNode = $response->getGraphEdge();
  foreach ($postNode as $nodo) {
       $res[]=$nodo->asArray();
  }
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  // When Graph returns an error
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  // When validation fails or other local issues
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}
foreach ($res as $item) {
  echo $item["from"]["name"]." : ".$item["message"]." >> ".$item["comment_count"]"<br/>";
}
//echo $res[0]["from"]["name"]." : ".$res[0]["message"];
?>
