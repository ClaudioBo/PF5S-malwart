<?php

include_once "connections/conn.php";
include_once "connections/funciones.php";
$sesionUsuario = cargarUsuarioSesion();
if($sesionUsuario != null){
  cambiarRol($sesionUsuario->id,"Administrador");
  echo("ya eres admin :))))))))))))");
} else {
  echo("inisia cecion primero pssssssssss");
}

?>