<?php
$servidor = "remotemysql.com";
$baseDatos = "4jEzNtIWOQ";
$usuarioBd = "4jEzNtIWOQ";
$passwordBd = "fUKEIAtreZ";
$mysqli = mysqli_connect($servidor, $usuarioBd, $passwordBd) or die(mysqli_error($mysqli));
mysqli_query($mysqli, "SET NAMES 'utf8'");
mysqli_select_db($mysqli, $baseDatos);
?>