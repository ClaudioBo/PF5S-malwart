<?php
$servidor = "localhost";
$baseDatos = "alonsmez_webapps";
$usuarioBd = "alonsmez_webapps";
$passwordBd = "L0quesea!";
$mysqli = mysqli_connect($servidor, $usuarioBd, $passwordBd) or die(mysqli_error($mysqli));
mysqli_query($mysqli, "SET NAMES 'utf8'");
mysqli_select_db($mysqli, $baseDatos);
?>