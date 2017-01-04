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

$flag=1;
$iterator=0;
$cola = [];
$cola[0]=$recurso;

while ($flag > 0) {
  try {
    $response = $fb2->get('/'.$cola[$iterator].'/comments?fields=from,message,comment_count');
    $postNode = $response->getGraphEdge();
    foreach ($postNode as $nodo) {
        $vector=$nodo->asArray();
        $sub=$vector["comment_count"];
        if ($sub > 0) {
          $iterator++;
          $flag++;
          $cola[$iterator]=$vector["id"];
        }
        $res[]=$vector;
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
  $flag--;
}

//var_dump($cola);
//echo "<br/>";

include "./ExtraeMail.php";
$data=new ExtraeMail();
foreach ($res as $item) {
  echo "<p>";
  var_dump($item);
  echo "</p>";
  $comentario=$item["message"]."";
  echo "<br/>".$comentario."<br/>";
  echo $data->debug();
  //$data->Extraer($comentario);
  // $correos=$data->getCorreos();
  // $m=count($correos);
  // for ($i=0; $i < $m; $i++) {
  //   echo $item["from"]["name"]." : ".$correos[$i]."<br/>";
  // }
}
?>
