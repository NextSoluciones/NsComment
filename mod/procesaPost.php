<?php
session_start();
include "./../bin/config.php";
require_once __DIR__ . './../vendor/autoload.php';
$accesso= new Config();

$fb2 = new Facebook\Facebook([
  'app_id' => '',
  'app_secret' => '',
  'default_graph_version' => $accesso->get_version()
]);

$post=$_POST['id_post'];
echo $post;
?>
