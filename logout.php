<?php
include_once "connections/conn.php";
include_once "connections/funciones.php";
$sesionUsuario = cargarUsuarioSesion();
if($sesionUsuario != null){
  session_destroy();
}
header('Location: error.php');
?>