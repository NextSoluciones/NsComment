<?php
if(!session_id()) {
session_start();
}
$id=date("_d-m-Y-(H-i-s)");
if ( !empty($_POST["registro"]) && is_array($_POST["registro"]) ) {
    header('Content-type: text/plain');
    header("Content-Disposition: attachment; filename=\"facebook$id.csv\"");
    foreach ( $_POST["registro"] as $registro ) {
            print utf8_decode($registro);
     }
}
?>
