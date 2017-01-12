<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>nscomment</title>
    <link rel="stylesheet" href="./../index.css">
    <link href="https://fonts.googleapis.com/css?family=Lato:700" rel="stylesheet">
  </head>
  <body>
    <h1>Gestion de Comentarios</h1>
<?php
//error_reporting(E_ALL);
//ini_set('display_errors', '1');
//ini_set('memory_limit', '512M');
session_start();
include "./../bin/config.php";
require_once "ExtraeMail.php";
require_once __DIR__ . './../vendor/autoload.php';
$accesso= new Config();
$data=new ExtraeMail();
$fb2 = new Facebook\Facebook([
  'app_id' => $accesso->get_id(),
  'app_secret' => $accesso->get_secret(),
  'default_graph_version' => $accesso->get_version()
]);

$post=$_POST['id_post'];
$id=$_POST['fanpage'];
$recurso=$id."_".$post;
$res = [];
$fb2->setDefaultAccessToken($_SESSION['facebook_access_token']);

$flag=1;
$iterator=0;
$cola = [];
$cola[0]=$recurso;
$icomment=0;
while ($flag > 0) {
  try {
    $response = $fb2->get('/'.$cola[$icomment].'/comments?fields=from,message,comment_count');
    //echo "<br>cola[".$icomment."]=".$cola[$icomment]."</br>";
    $postNode = $response->getGraphEdge();
    foreach ($postNode as $nodo) {
        $vector=$nodo->asArray();
        $sub=$vector["comment_count"];
        if ($sub > 0) {
          $iterator++;
          $flag++;
          $cola[$iterator]=$vector["id"];
          //echo "<br>cola[".$iterator."]=".$cola[$iterator]."</br>";
        }
        $res[]=$vector;
    }
    $icomment++;
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
//var_dump($res);
echo "<form id='formH' action='descargar.php' method='post'><input type='submit' value='Descargar'><br/>";
echo "<div class='datagrid'><table><thead><tr><th>Usuario</th><th>Correo</th></tr></thead><tbody>";
foreach ($res as $item) {
  $comentario=$item["message"];
  try {
    $res=$data->Extraer($comentario);
  } catch (Exception $e) {
    echo "<br/>Excepción: ".$e."<br/>";
  }
  //echo "Debugg: ".$data->debug();
  $correos=$data->getCorreos();
  $m=count($correos);
  for ($i=0; $i < $m; $i++) {
    echo "<tr><td>".$item["from"]["name"]."</td><td>".$correos[$i]."</td></tr>";
    echo "<input type='hidden' name='registro[]' value='".$item["from"]["name"].",".$correos[$i]."\n'>";
  }
}
echo "</tbody></table></div>";
echo "</form>";
?>
<footer><ul id="pie">
  <li>Desarrollado por <a href="https://www.nslatino.com">Next Soluciones Inform&aacute;ticas</a> - Todos los derechos reservdos</li>
</ul></footer>
</body>
</html>
