<?php
session_start();
if ( !empty($_POST["registro"]) && is_array($_POST["registro"]) ) {
    echo "<ul>";
    foreach ( $_POST["registro"] as $registro ) {
            echo "<li>";
            echo $registro;
            echo "</li>";
     }
     echo "</ul>";
}
?>
