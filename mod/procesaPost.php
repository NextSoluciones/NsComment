<?php
session_start();
include "./../bin/config.php";
require_once __DIR__ . './../vendor/autoload.php';
$fb = new Facebook('app_id' => '',
'app_secret' => '',
'default_graph_version' => '');

$post=$_POST['id_post'];
echo $post;
?>
