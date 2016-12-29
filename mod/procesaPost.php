<?php
session_start();
include "./../bin/config.php";
require_once __DIR__ . './../vendor/autoload.php';
$fb = new Facebook\Facebook();

$post=$_POST['id_post'];
echo $post;
?>
