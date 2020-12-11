<?php

include_once "connections/conn.php";
include_once "connections/funciones.php";
$sesionUsuario = cargarUsuarioSesion();
if($sesionUsuario != null){
  cambiarRol($sesionUsuario->id,"Normal");
  echo("ya eres al q le robamos dinero :))))))))))))");
} else {
  echo("inisia cecion primero pssssssssss");
}
