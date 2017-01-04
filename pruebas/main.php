<?php
session_start();
include "./ExtraeMail.php";
  $cad="Hola a todos les paso mi correo:ajms@yahoo.com.es pero.pe su pronta respuesta. Tambien me pueden escribir al:2012100594@ucss.pe.gracias";
  $data=new ExtraeMail();
  $data->Extraer($cad);
  $correos=$data->getCorreos();
  var_dump($correos);
  echo "<br/>";
  //echo $data->debug();
?>
