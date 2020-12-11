<?php
include_once "connections/conn.php";
include_once "connections/funciones.php";
$sesionUsuario = cargarUsuarioSesion();
session_destroy();
header('Location: index.php');
?>