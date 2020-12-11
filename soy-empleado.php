<?php

include_once "connections/conn.php";
include_once "connections/funciones.php";
$sesionUsuario = cargarUsuarioSesion();
if($sesionUsuario != null){
  cambiarRol($sesionUsuario->id,"Empleado");
  echo("ya eres godines :))))))))))))");
} else {
  echo("inisia cecion primero pssssssssss");
}

?>